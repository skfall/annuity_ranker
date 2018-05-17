@extends('layouts.default')

@section('content')

<section class="psc psc-calc">
        <div class="pwr">
            <div class="pct">
                <header class="sct-header">
                    <h1 class="title number-big">
                        <span class="value c_link">
                            @if ($texts[1]['l'])
                            <a href="{{$texts[1]['l']}}" target="_blank">{!!$texts[1]['v']!!}</a>
                            @else
                            {!! $texts[1]['v'] !!} 
                            @endif
                        </span>

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
    
                <form action="#" method="POST" class="panel" id="filter_form">
                    <div class="fields-ct">
                        <div class="fields-row fields-row-main">
    
                            <div class="field field-radio-btns field-type">
                                <div class="field__ct">
                                    <div class="field__title">Annuity Type</div>
                                    <div class="field__input">
                                        @foreach ($annuities as $item)
                                            <?php 
                                                $checked_type = "";
                                                if($item->id == $annuity->id) $checked_type = "checked";
                                            ?>
                                            <label class="field-radio-btn col-3"><input type="radio" name="type" {{$checked_type}} value="{{$item->id}}"><span class="box"><span class="text">{{ $item->name }}</span></span></label>
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
                                    <div class="field__input">
                                        <input type="text" name="amount" class="js_input-number js_input-money" value="{{ $default_amount }}">
                                    </div>
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
                                        <label class="field-radio"><input type="radio" name="spousal-rates" val="yes" value="1" {{ $active_1 }} class="js_spousal-rates-input"><span class="box"></span><span class="text">Yes</span></label>
                                        <label class="field-radio"><input type="radio" name="spousal-rates" val="no" value="0" $active_2 }}><span class="box"></span><span class="text">No</span></label>
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
                                <button type="button" class="btn btn-blue" onclick="network.get_companies(event, this)"><span class="text">Search</span></button>
                            </div>
    
                            <div class="form-msgs">
                                <div class="msg active response"></div>
                            </div>
    
                        </div>
                    </div>
                </form>
    
                <div class="result" id="search_result">
                    @include('elements.companies', [
                        'companies' => $companies,
                        'annuity' => $annuity,
                        'curr_count' => 0,
                        'count_left' => $count_left
                    ])
                </div>
    
            </div>
        </div>
    </section>
@endsection