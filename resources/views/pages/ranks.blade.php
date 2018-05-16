@extends('layouts.default')

@section('content')

<section class="psc psc-calc">
        <div class="pwr">
            <div class="pct">
                <header class="sct-header">
                    <h1 class="title number-big c_link">
                        @if ($texts[1]['l'])
                            <a href="{{$texts[1]['l']}}" target="_blank">{!!$texts[1]['v']!!}</a>
                        @else
                            {!! $texts[1]['v'] !!} 
                        @endif

                        <span class="ending c_link" style="font-family: 'SairaExtraCondensed-Bold'">
                            @if ($texts[2]["v"])
                                @if ($texts[2]["l"])
                                    <a href="{{ $texts[2]["l"] }}" target="_blank">{!! $texts[2]["v"] !!}</a>
                                @else
                                    {!! $texts[2]["v"] !!}
                                @endif  
                            @else
                                <span style="font-family: 'SairaExtraCondensed-Bold'"><?= "For ".date("M y"); ?></span>
                            @endif
                            
                        </span>
                    </h1>
                    <div class="link ttp ttp--right js_ttp">
                        <span class="link-text c_link">
                            @if ($texts[4]["l"])
                                <a href="{{ $texts[4]["l"] }}" target="_blank">{!! $texts[4]["v"] !!}</a>
                            @else
                                {!! $texts[4]['v'] !!}
                            @endif
                        </span>
                        <div class="ttp__wr">
                            <div class="ttp__ct">
                                <div class="ttp__text c_link">
                                    @if ($texts[5]['l'])
                                        <a href="{{ $texts[5]["l"] }}" target="_blank">{!! $texts[5]["v"] !!}</a>
                                    @else
                                        {!! $texts[5]['v'] !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text c_link">
                        @if ($texts[3]['l'])
                            <a href="{{ $texts[3]["l"] }}" target="_blank">{!! $texts[3]["v"] !!}</a>
                        @else
                            {!! $texts[3]['v'] !!}
                        @endif
                    </div>
                </header>
    
                <form class="panel">
                    <div class="fields-ct">
                        <div class="fields-row fields-row-main">
    
                            <div class="field field-radio-btns field-type">
                                <div class="field__ct">
                                    <div class="field__title">Annuity Type</div>
                                    <div class="field__input">
                                        @foreach ($annuities as $item)
                                            <label class="field-radio-btn col-3"><input type="radio" name="type" checked><span class="box"><span class="text">{{ $item->name }}</span></span></label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
    
                            <label class="field field-money field-purchase-amount">
                                <?php 
                                    $default_amount = $annuity->default_amount;
                                    if(!$default_amount) $default_amount = 0;

                                ?>
                                <div class="field__ct">
                                    <div class="field__title">Annuity Purchase Amount</div>
                                    <div class="field__input"><input type="text" class="js_input-number js_input-money" value="{{ $default_amount }}"></div>
                                </div>
                            </label>
    
                            <div class="field field-radios field-spousal-rates">
                                <div class="field__ct">
                                    <div class="field__title">Check Spousal Rates?</div>
                                    <div class="field__input">
                                        <?php 
                                            if ($annuity->special_active == 1) {
                                                $active_1 = "checked";
                                                $active_2 = "";
                                            }else{
                                                $active_1 = "";
                                                $active_2 = "checked";
                                            }   
                                        ?>
                                        <label class="field-radio"><input type="radio" name="spousal-rates" val="yes" {{ $active_1 }} class="js_spousal-rates-input"><span class="box"></span><span class="text">Yes</span></label>
                                        <label class="field-radio"><input type="radio" name="spousal-rates" val="no" {{ $active_2 }}><span class="box"></span><span class="text">No</span></label>
                                    </div>
                                </div>
                            </div>
    
                            <label class="field field-age">
                                <div class="field__ct">
                                    <?php 
                                        $default_age = $annuity->age;
                                        if (!$default_age) $default_age = 0;
                                    ?>
                                    <div class="field__title">Your Age</div>
                                    <div class="field__input"><input type="text" name="user-age" class="js_input-number" value="{{ $default_age }}"></div>
                                </div>
                            </label>
                            
                            <?php 
                                $disabled = "disabled";
                                $default_spouse_age = $annuity->special_age;
                                if($annuity->special_active == 1) {
                                    $disabled = "";
                                }else{
                                    $default_spouse_age = "";
                                }
                                
                                // invalid - class for field
                            ?>

                            <label class="field field-age {{ $disabled }} ">
                                
                                <div class="field__ct">
                                    <div class="field__title">Spouse Age</div>
                                    <div class="field__input"><input type="text" name="spouse-age" class="js_input-number js_spouse-age-input" {{ $disabled }} value="{{ $default_spouse_age }}"></div>
                                </div>
                            </label>
    
                            <div class="field field-submit-btn">
                                <button type="submit" class="btn btn-blue"><span class="text">Search</span></button>
                            </div>
    
                            <div class="form-msgs response">
                                {{-- <div class="msg active">Please input the age of your spouse</div> --}}
                            </div>
    
                        </div>
                    </div>
                </form>
    
                <div class="result">
                    <div class="r-header-holder">
                        <table class="r-header">
                            <tbody>
                                <tr>
                                    <td class="r-cell cell-1">
                                        <span class="text">{!! $annuity->col_1 !!}</span>
                                    </td>
                                    <td class="r-cell cell-2">
                                        <span class="text">{!! $annuity->col_2 !!}</span>
                                    </td>
                                    <td class="r-cell cell-3">
                                        <span class="text">{!! $annuity->col_3 !!}</span>
                                    </td>
                                    <td class="r-cell cell-4">
                                        <span class="text">{!! $annuity->col_4 !!}</span>
                                    </td>
                                    <td class="r-cell cell-5">
                                        <span class="text">{!! $annuity->col_5 !!}</span>
                                    </td>
                                    <td class="r-cell cell-bonus">
                                        <span class="text">{!! $annuity->col_6 !!}</span>
                                    </td>
                                    <td class="r-cell cell-btn">
                                        <span class="text">{!! $annuity->col_7 !!}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="r-main">
                        @forelse ($companies as $item)
                            <table class="r-main-table js_tgl" data-company="{{ $item->id }}" data-toggler="{{ $item->id }}">
                                <tbody>
                                    <tr>
                                        <td class="r-cell cell-company-name">
                                            <span class="t-mobile">{!! $annuity->col_1 !!}</span>
                                            <div class="content">
                                                <h4 class="company-name">{{ $item->td_field_15_r1 }}</h4>
                                                <h4 class="company-name">{{ $item->td_field_15_r2 }}</h4>
                                                <h4 class="company-name">{{ $item->td_field_15_r3 }}</h4>
                                                <h4 class="company-name">{{ $item->td_field_15_r4 }}</h4>
                                                <span class="license">{{ $item->td_field_14 }}</span>
                                                <div class="bottom">
                                                    @if ($item->tabs()->count() > 0)
                                                        <button class="btn btn-toggler js_tgl-trigger btn-open-details" data-toggler="{{ $item->id }}"><span class="box"></span><span class="text">{{ $item->td_field_16 }}</span></button>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="r-cell cell-company-logo">
                                            <span class="t-mobile"><span class="text">{!! $annuity->col_2 !!}</span></span>
                                            <div class="content">
                                                @if ($item->logo)
                                                    <a href="javascript:void(0)" class="company-logo"><img src="{{ UPLOADS.'companies/'.$item->logo }}" alt=""></a>
                                                @endif
                                                <div class="bottom">
                                                    <span class="credit-rating">{!! $item->td_field_11 !!}</span>
                                                    @if ($item->td_field_10_r1 || $item->td_field_9_r1)    
                                                        <div class="center-ct tel-center-ct" style="height: auto;">
                                                            <div class="cell-text center">{{ $item->td_field_10_r1 }} {{ $item->td_field_9_r1}} 
                                                                {{-- <a href="javascript:void(0)">More details</a></div> --}}
                                                        </div>
                                                    @endif
                                                    @if ($item->td_field_10_r2 || $item->td_field_9_r2)    
                                                        <div class="center-ct tel-center-ct" style="height: auto;">
                                                            <div class="cell-text center">{{ $item->td_field_10_r2 }} {{ $item->td_field_9_r2}} 
                                                        </div>
                                                    @endif
                                                    @if ($item->td_field_10_r3)    
                                                        <div class="center-ct tel-center-ct" style="height: auto;">
                                                            <div class="cell-text center">{{ $item->td_field_10_r3 }}
                                                        </div>
                                                    @endif
                                                    @if ($item->td_field_10_r4)    
                                                        <div class="center-ct tel-center-ct" style="height: auto;">
                                                            <div class="cell-text center">{{ $item->td_field_10_r4 }} 
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="r-cell cell-growth-rate">
                                            <span class="t-mobile"><span class="text">{!! $annuity->col_3 !!}</span></span>
                                            <div class="content">
                                                <span class="number-big">
                                                    <?php 
                                                        $growth = $item->growth_rate;
                                                        $new_row = [];
                                                        for($i = 0; $i < mb_strlen($growth); $i++){
                                                            if($growth[$i] == "%"){
                                                                $new_row[$i] = "<span class='ending'>%</span>";
                                                            }elseif($growth[$i] == "/"){
                                                                $new_row[$i] = "<span class='separator'>/</span>";
                                                            }else{
                                                                $new_row[$i] = "<span class='value'>".$growth[$i]."</span>";      
                                                            }
                                                        }

                                                        $growth = implode('',$new_row);
                                                    ?>
                                                    {!! $growth !!}
                                                    @if ($item->td_field_29_plus == 1 && $item->tabs()->count() > 0)
                                                        <button class="btn btn-toggler js_tgl-trigger btn-open-details" data-toggler="{!! $item->id !!}"><span class="box"></span></button></span>
                                                    @endif
                                                <div class="bottom">
                                                    <div class="center-ct growth-center-ct" style='height: auto;'>
                                                        <div class="cell-text center">{{ $item->td_field_8_r1 }}</div>
                                                    </div>
                                                    <div class="center-ct growth-center-ct" style='height: auto;'>
                                                        <div class="cell-text center">{{ $item->td_field_8_r2 }}</div>
                                                    </div>
                                                    <div class="center-ct growth-center-ct" style='height: auto;'>
                                                        <div class="cell-text center">{{ $item->td_field_8_r3 }}</div>
                                                    </div>
                                                    <div class="center-ct growth-center-ct" style='height: auto;'>
                                                        <div class="cell-text center">{{ $item->td_field_8_r4 }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="r-cell cell-fee">
                                            <span class="t-mobile"><span class="text">{!! $annuity->col_4 !!}</span></span>
                                            <div class="content">
                                                <span class="number-big"><span class="value">{{ $item->percent }}</span><span class="ending">%</span>
                                                @if ($item->percent_plus == 1 && $item->tabs()->count() > 0)
                                                    <button class="btn btn-toggler js_tgl-trigger btn-open-details" data-toggler="{!! $item->id !!}"><span class="box"></span></button></span>
                                                @endif
                                                
                                                <div class="bottom">
                                                    <div class="center-ct fee-center-ct" style='height: auto;'>
                                                        <div class="cell-text center">{{ $item->td_field_7_r1 }}</div>
                                                    </div>
                                                    <div class="center-ct fee-center-ct" style='height: auto;'>
                                                        <div class="cell-text center">{{ $item->td_field_7_r2 }}</div>
                                                    </div>
                                                    <div class="center-ct fee-center-ct" style='height: auto;'>
                                                        <div class="cell-text center">{{ $item->td_field_7_r3 }}</div>
                                                    </div>
                                                    <div class="center-ct fee-center-ct" style='height: auto;'>
                                                        <div class="cell-text center">{{ $item->td_field_7_r4 }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="r-cell cell-withdrawal">
                                            <span class="t-mobile"><span class="text">{!! $annuity->col_5 !!}</span></span>
                                            <div class="content">
                                                <span class="number-big">
                                                    <?php 
                                                        $withdraw = $item->withdrawal_rate;
                                                        $new_row = [];
                                                        for($i = 0; $i < mb_strlen($withdraw); $i++){
                                                            if($withdraw[$i] == "%"){
                                                                $new_row[$i] = "<span class='ending'>%</span>";
                                                            }elseif($withdraw[$i] == "/"){
                                                                $new_row[$i] = "<span class='separator'>/</span>";
                                                            }else{
                                                                $new_row[$i] = "<span class='value'>".$withdraw[$i]."</span>";      
                                                            }
                                                        }
                                                        $withdraw = implode('',$new_row);
                                                    ?>
                                                    {!! $withdraw !!}
                                                    @if ($item->td_field_27_plus == 1 && $item->tabs()->count() > 0)
                                                        <button class="btn btn-toggler js_tgl-trigger btn-open-details" data-toggler="{!! $item->id !!}"><span class="box"></span></button></span>
                                                    @endif
                                                <div class="bottom">
                                                    {{-- <div class="center-ct withdrawal-center-ct">
                                                        <div class="cell-text center">Surrender Charges: some text of available surrender charges</div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="r-cell cell-bonus">
                                            <span class="t-mobile"><span class="text">{!! $annuity->col_6 !!}</span></span>
                                            <div class="content">
                                                <?php 
                                                    $bonus = str_replace('%', '<span class="ending">%</span>', $item->td_field_30);
                                                ?>
                                                <span class="number-big"><span class="value">{!! $bonus !!}</span></span>
                                            </div>
                                        </td>
                                        <td class="r-cell cell-btn">
                                            <span class="t-mobile"><span class="text"></span></span>
                                            @if ($item->td_field_31) 
                                                <a href="{{$item->td_field_31}}" class="btn btn-green" target="_blank"><span class="text">Next<span class="icon icon-arrow-right3"></span></span></a>
                                            @endif
                                            <div class="bottom">
                                                <div class="center-ct updated-center-ct">
                                                    <div class="cell-text center">Updated: <?= date("M y"); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if ($item->tabs()->count() > 0)  
                                        <tr class="r-details tgl__body js_tgl-body" data-toggler="{!! $item->id !!}">
                                                <td class="r-details-ct js_tgl-body-ct" data-toggler="{!! $item->id !!}">
                                                        <div class="tabs js_tabs-scope" data-tabs="{!! $item->id !!}">
                                                                <div class="tabs-header">
                                                        <div class="left">
                                                            @foreach ($item->tabs()->get() as $tkey => $tab)
                                                                <?php
                                                                    $active = $tkey == 0 ? "active" : "";
                                                                ?>
                                                                <a href="javascript:void(0)" class="tabs-link js_tabs-trigger {{$active}}" data-tabs="{!! $item->id !!}" data-tab="{{ $tkey }}">{{ $tab->name }}</a>
                                                            @endforeach
                                                        </div>
                                                        <button type="button" class="btn btn-block-close js_tgl-trigger btn-open-details" data-toggler="{!! $item->id !!}"><span class="text">Close<span class="icon icon-cross4"></span></span></button>
                                                    </div>
                                                    <div class="tabs-body">
                                                        @foreach ($item->tabs()->get() as $tkey => $tab)
                                                            <?php
                                                                $active = $tkey == 0 ? "active" : "";
                                                            ?>
                                                            <div class="tab js_tabs-target content_target {{$active}}" data-tabs="{!! $item->id !!}" data-tab="{{$tkey}}" style="text-align: left; padding-top: 20px;">
                                                                    {!! $tab->content !!}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @empty
                            <table class="r-main-table">
                                <tbody>
                                    <tr>
                                        <td class="r-cell cell-company-name" colspan="7" style="width: 100%;">
                                            <div class="content">
                                                <div class="space10"></div>
                                                <h4 class="company-name tac">No results</h4>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforelse
                    </div>

                </div>
    
            </div>
        </div>
    </section>
@endsection