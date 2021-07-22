<?php

namespace App\Http\Controllers;

use App\Exports\DocumentCampaignExport;
use App\Models\Campaign;
use App\Models\CampaignDocument;
use Illuminate\Http\Request;

use App\Http\Traits\FileTrait;
use App\Models\BitacoraDocuments;
use App\User;
use League\CommonMark\Block\Element\Document;
use Maatwebsite\Excel\Facades\Excel;

class ProducersDocumentsController extends Controller
{
    use FileTrait;

    /**
    * @return
    */
    public function __construct()
    {
        $this->middleware(['auth', 'roles:Producer,Administrador']);
    }

    /**
     * Method to see documentation
     */
    public function documentacion(Campaign $campaign)
    {
        if ( $campaign->status != 1 ) {
            return redirect()->route('producers.dashboard');
        }

        return view('admin.producers.documents.index',[
            'campaign'  => $campaign,
            'documents' => CampaignDocument::whereCampaignId($campaign->id)->orderBy('id', 'desc')->paginate(3),
            "bitacora"  => BitacoraDocuments::with("user")->whereCampaignId( $campaign->id )->orderBy("id", "desc")->get()
        ]);
    }

    /**
     * Method to can upload a PDF file
     */
    public function documentacionAdd(Campaign $campaign)
    {
        return view("admin.producers.documents.create",[
            "campaign"  => $campaign,
            'document'  => new CampaignDocument()
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function documentacionSave(Campaign $campaign, Request $request)
    {
        $newFileName = $this->uploadFileToServer(
                            "public/documents/campaign$campaign->id/",
                            $request->file('pdfile')
                        );

        /* se almacena el registro de este lado */
        $data                   = $request->all();
        $data['file']           = $newFileName;
        $data['campaign_id']    = $campaign->id;
        $data['user_id']        = auth()->user()->id;

        unset( $data['_token'] );
        unset( $data['pdfile'] );

        $response = CampaignDocument::create($data);

        if ( isset($response->id) ) {
            return [
                'status'    => 'success',
                'message'   => 'Documento guardado exitosamente.'
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Ocurrió un error, por favor intentelo mas tarde.'
        ];
    }

    /**
    * @method
    * @param
    * @return
    */
    public function documentacionEdit(Campaign $campaign, CampaignDocument $document)
    {
        return view("admin.producers.documents.edit",[
            "campaign"  => $campaign,
            'document'  => $document
        ]);
    }

    /**
    * @method
    * @param
    * @return
    */
    public function documentacionUpdate(Campaign $campaign, CampaignDocument $document, Request $request)
    {

        if ( $request->file('pdfile') != null ) {
            $newFileName = $this->uploadFileToServer(
                "public/documents/campaign$campaign->id/",
                $request->file('pdfile')
            );
        } else {
            $newFileName = $document->file;
        }

        /* se almacena el registro de este lado */
        $data                   = $request->all();
        $data['file']           = $newFileName;

        unset( $data['_token'] );
        unset( $data['pdfile'] );

        $response = CampaignDocument::whereId($document->id)->update($data);


        if ( $response ) {
            return [
                'status'    => 'success',
                'message'   => 'Documento guardado exitosamente.'
                ];
        }

        return [
            'status' => 'error',
            'message' => 'Ocurrió un error, por favor intentelo mas tarde.'
        ];
    }

    /**
    * @method
    * @param
    * @return
    */
    public function documentacionDelete(Campaign $campaign, CampaignDocument $document)
    {
        if ( CampaignDocument::whereId( $document->id )->update( ['status' => 0] ) ) {
            return redirect()->route('producers.documentacion', $campaign)->with('status', [
                'status'    => 'success',
                'message'   => 'Documento eliminado'
            ]);
        }

        return redirect()->route('producers.documentacion', $campaign)->with('status', [
            'status'    => 'error',
            'message'   => 'Ocurrió un error. Intentelo nuevamente'
        ]);
    }

    /**
     *
     */
    public function bitacoraSave(Request $request)
    {
        $data               = $request->all();
        $data["user_id"]    = auth()->user()->id;
        unset($data["_token"]);
        $response = BitacoraDocuments::create( $data );
        // agregamos el nombre a la respuesta
        $response["producer"] = User::whereId(auth()->user()->id)->select("name")->first();
        $response["desde"]      = $response->created_at->diffForHumans();
        return $response;
    }

    /**
    * @method
    * @param
    * @return
    */
    public function exportToCSV(Campaign $campaign)
    {
        $docs       =  CampaignDocument::whereCampaignId($campaign->id)->orderBy('id', 'desc')->get();
        $data = [
            'campaign'  => $campaign,
            'docs'      => $docs
        ];
        /* se hace el recorrido de la campa;a para poderla pintar en tabla */
        $file = [];
        $row = array();
        foreach ($data["docs"] as $key => $documento) {
            /* cuando se termina el foreach se escriben los resultados */
            $url = asset("/storage/documents/campaign".$data['campaign']->id."/$documento->file");
            $row = [
                $data["campaign"]->name,
                '=HIPERVINCULO("'.$url.'", "'.$documento->name.'")',
                strip_tags($documento->description),
                $documento->created_at,
                $documento->user->name
            ];
            array_push($file, $row);
        }

        $fileName   = $campaign->name."_documentos.xlsx";
        $export = new DocumentCampaignExport($file);
        return Excel::download($export,$fileName);
    }
}
