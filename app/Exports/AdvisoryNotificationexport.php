<?php

namespace App\Exports;

use App\Models\AdvisoryNotification;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use DB;
// use Maatwebsite\Excel\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Illuminate\Contracts\Queue\ShouldQueue;

// FromQuery,
class AdvisoryNotificationexport implements FromCollection, WithHeadings
{
    protected $request;
    protected $marketid,$courseid,$from,$to;
    public function __construct(String $from,String $to,String $courseid,String $marketid) {
        $this->marketid  = $marketid;
        $this->courseid = $courseid;
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {   
        $from = date('Y-m-d',strtotime($this->from));
        $to = date('Y-m-d',strtotime($this->to));
        $advtisearr = AdvisoryNotification::select('id','advisorySection','tradeDate','script','action_trade','quantity','price','stoploss','status','target','timeline')->where('userId', NULL)->where('parentId', NULL)->where('courseId', $this->courseid)->where('marketId', $this->marketid)->whereBetween('tradeDate', [$from, $to])->get();    
        $arrfilteradvtise = array();
        
        foreach($advtisearr as $advtisekey => $advtiseval){
            
            $buyqty = '';
            $buyprice = '';
            $buyvalue = '';
            $sellqty = '';
            $sellprice = '';
            $sellvalue = '';
            $total = '';
            $actionrequire = '';
            if($advtiseval->action_trade==1){               
                // buy code here
                $buyqty = $advtiseval->quantity;
                $buyprice =  $advtiseval->price;
                $buyvalue = $buyprice * $buyqty;
                // buy code here
                $total = 'plus';
                $actionrequire = 'BUY';
            }
            
            if($advtiseval->action_trade==2){
                // sell code here
                $sellqty = $advtiseval->quantity;
                $sellprice = $advtiseval->price;
                $sellvalue = $sellprice * $sellqty;
                // sell code here
                $total = 'minus';
                $actionrequire = 'SELL';
            }
            
            $parentarr = AdvisoryNotification::select('id','advisorySection','tradeDate','script','action_trade','quantity','price','stoploss','target','timeline')->where('userId', NULL)->where('parentId',$advtiseval->id)->first();
            
            if(!empty($parentarr)){                
                if($parentarr['action_trade'] == 1){               
                    // buy code here
                    $buyqty = $parentarr['quantity'];
                    $buyprice =  $parentarr['price'];
                    $buyvalue = $buyprice * $buyqty;
                    // buy code here
                }
                
                if($parentarr['action_trade'] == 2 ){
                    // sell code here
                    $sellqty = $parentarr['quantity'];
                    $sellprice = $parentarr['price'];
                    $sellvalue = $sellprice * $sellqty;
                    // sell code here
                }
            }

            $status = '';
            if($advtiseval->status==0){
                $status = 'Opened';
            }
            if($advtiseval->status==1){
                $status = 'Closed';
            }
            if($advtiseval->status==2){
                $status = 'Fail';
            }
            if($advtiseval->status==3){
                $status = 'Success';
            }
            // $arrfilteradvtise[$advtisekey]['advisorySection'] = $advtiseval->advtiseval;

            $arrfilteradvtise[] = array(
                'ADVISORY SECTION'  => $advtiseval->advisorySection,
                'TRADE DATE'   => $advtiseval->tradeDate,
                'SCRIPT'    => $advtiseval->script,
                'ACTION REQUIRED'  => $actionrequire,
                'QUANTITY'   => $buyqty,
                'BUYING PRICE'   => $buyprice,
                'BUYING VALUE'   => $buyvalue,
                'STOPLOSS'   => $advtiseval->stoploss,
                'TARGET'   => $advtiseval->target,
                'TIMELINE'   => $advtiseval->timeline,
                'SELLING PRICE'   => $sellprice,
                'QTY'   => $sellqty,
                'SELLING VALUE'   => $sellvalue,
                'PROFIT / LOSS'   => '',
                '% PROFIT'   => '',
                'CALL STATUS'   => $status
            );            
        }
       
        return collect($arrfilteradvtise);
        // return AdvisoryNotification::select('advisorySection','tradeDate','script')->get();
        // $collection = $advtisearr->each(function ($item, $key) {
        //     //
        // });
    }

    public function headings(): array
    {
        return [
            'ADVISORY SECTION',
            'TRADE DATE',
            'SCRIPT',
            'ACTION REQUIRED',
            'QTY',
            'BUYING PRICE',
            'BUYING VALUE',
            'STOPLOSS',
            'TARGET',
            'TIMELINE',
            'SELLING PRICE',
            'QTY',
            'SELLING VALUE',
            'PROFIT / LOSS',
            '% PROFIT',
            'CALL STATUS',
        ];
    }    
}