<?php

namespace App\Console\Commands;

use App\erp\Gxywhz_bj;
use App\Goods;
use App\SalesVolume;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Gxywhz_bj as gxywhz;
use App\Lsb_bj as lsb;

class sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:sales {--queue=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'tongbuxiaoliang';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        set_time_limit(600);
//        //$sales = SalesVolume::all();
//        $this->output->progressStart(SalesVolume::count());
//        DB::table('sales_volume')->chunk(100,function($sales_volume){
//            foreach($sales_volume as $v){
//                $goods = Goods::where('goods_id',$v->goods_id)->select('goods_id','sales_volume')->first();
//                if(!empty($goods)){
//                    $goods->sales_volume = $v->sales_volume;
//                    $goods->save();
//                }
//                $this->output->progressAdvance();
//            }
//        });

        $this->output->progressStart(Gxywhz_bj::count());
        Gxywhz_bj::with('lsb_bj')->where('djbh','>','XHCX00000023645')->orderBy('djbh')->chunk(100,function($gxywhz_bj){
            foreach($gxywhz_bj as $a) {
                $gxywhz = new gxywhz();
                $gxywhz->djbh = $a->djbh;
                $gxywhz->rq = $a->rq;
                $gxywhz->rq = $a->rq;
                $gxywhz->wldwid1 = $a->wldwid1;
                $gxywhz->wldwname = $a->wldwname;
                $gxywhz->hsje = $a->hsje;
                $gxywhz->songhfs = $a->songhfs;
                $gxywhz->shouhr = $a->shouhr;
                $gxywhz->lxdh = $a->lxdh;
                $gxywhz->lxshj = $a->lxshj;
                $gxywhz->dsfwl = $a->dsfwl;
                $gxywhz->shhdz = $a->shhdz;
                DB::transaction(function () use ($gxywhz, $a) {
                    if($gxywhz->save()) {
                        $goods = [];
                        foreach ($a->lsb_bj as $v) {
                            $new = [
                                'djbh' => $v->djbh,
                                'spbh' => $v->spbh,
                                'spmch' => $v->spmch,
                                'shpgg' => $v->shpgg,
                                'dw' => $v->dw,
                                'shengccj' => $v->shengccj,
                                'shl' => $v->shl,
                                'pihaoxs' => $v->pihaoxs,
                                'hshj' => $v->hshj,
                                'hsje' => $v->hsje,
                                'sxrq' => $v->sxrq,
                            ];
                            $goods[] = $new;
                        }
                        //$gxywhz->lsb()->saveMany($goods);
                        lsb::insert($goods);
                    }
                });
                $this->output->progressAdvance();
            }
            $end = strtotime('2016-03-11 17:30:00');
            if(time()>$end){
                return false;
            }
        });

        $this->output->progressFinish();
    }
}
