<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KpInstansi;
use App\KpMahasiswa;
use App\KpPeserta;
use App\KpProposal;
use App\Mahasiswa;
use DB;
Use Exception;

class ProposalKPController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:manage_proposalkp']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kp_proposals = KpProposal::paginate(25);
        return view('backend.proposal-kp.index', compact('kp_proposals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $instansi = KpInstansi::pluck('nama', 'id');
        return view('backend.proposal-kp.create', compact('instansi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        KpProposal::create($data);
        session()->flash('flash_success', 'Berhasil menambahkan data proposal kp dengan judul '. $request->input('judul'));
        return redirect()->route('admin.proposal-kp.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $KpProposal = DB::table('kp_proposal')
                        ->join('kp_instansi', 'kp_proposal.instansi_id', '=', 'kp_instansi.id')
                        ->select('kp_proposal.id', 'kp_proposal.judul', 'kp_proposal.latar_belakang', 'kp_proposal.tujuan', 'kp_proposal.usulan_mulai_at', 'kp_proposal.usulan_selesai_at', 'kp_proposal.catatan', 'kp_instansi.nama', DB::raw('(CASE WHEN kp_proposal.status_proposal = 1 THEN '. "'Disetujui'" .'ELSE' . "'Belum/Tidak Disetujui'" . 'END) AS status_proposal'))
                        ->where('kp_proposal.id', '=', $id)
                        ->get();
        $KpProposal = $KpProposal[0];
        
        // dd($anggotas);
        return view('backend.proposal-kp.show', compact('KpProposal'));
    }

    public function showKelompok($id)
    {
        $KpProposal = KpProposal::all()[0];
        $anggotas = DB::table('kp_proposal')
                        ->join('kp_mahasiswa', 'kp_proposal.id', '=', 'kp_mahasiswa.kp_proposal_id')
                        ->join('kp_peserta', 'kp_mahasiswa.id', '=', 'kp_peserta.kp_mahasiswa_id')
                        ->join('mahasiswa', 'kp_peserta.mahasiswa_id', '=', 'mahasiswa.id')
                        ->where('kp_proposal.id', '=', $id)
                        ->get();
        return view('backend.proposal-kp.showKelompok', compact('anggotas', 'KpProposal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $KpProposal=KpProposal::findOrFail($id);
        $instansis = KpInstansi::all();
        // dd($KpProposal);
        return view('backend.proposal-kp.edit', compact('KpProposal', 'instansis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $proposal = KpProposal::findOrFail($id);
        $data = $request->all();
        $proposal->update($data);
        session()->flash('flash_success', 'Berhasil mengupdate data proposal kp '.$request->input('judul'));
        return redirect()->route('admin.proposal-kp.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $proposal = KpProposal::findOrFail($id);
        try{
            KpProposal::destroy($id);
            session()->flash('flash_success', 'Berhasil Menghapus data proposal kp dengan judul '.$proposal->judul);
        } catch(Exception $e){
            session()->flash('flash_warning', 'Gagal Menghapus data proposal kp dengan judul '.$proposal->judul);
        }
        return redirect()->route('admin.proposal-kp.index');

    }

    public function add($id)
    {
        $KP = DB::table('kp_proposal')
                ->join('kp_mahasiswa', 'kp_proposal.id', '=', 'kp_mahasiswa.kp_proposal_id')
                ->select('kp_mahasiswa.id')
                ->where('kp_proposal.id', '=', $id)
                ->get();
        $KP = $KP[0];
        $mhs = Mahasiswa::pluck('nama', 'id');
        return view('backend.proposal-kp.add', compact('mhs', 'KP'));
    }

    public function insert(Request $request)
    {
        $data = $request->all();
        KpPeserta::create($data);
        session()->flash('flash_success', 'Berhasil menambahkan data anggota KP');
        return redirect()->route('admin.proposal-kp.index');
    }
}
