@extends('layouts.default')

@section('content')
    <section class="psc psc-main">
        <div class="sct-bg">
            <div class="bg active js_choice-bg" data-choice="0">
                <div class="img" style="background-image: url('{{ IMG.'content/bg0.jpg' }}')"></div>
            </div>
            @foreach ($annuities as $key => $item)
                @if ($item->is_video_bg)
                    <div class="bg js_choice-bg" data-choice="{{ $item->id }}">
                        <div class="img">
                            <video loop="" muted="">
                                <source src="{{ UPLOADS.'annuities/'.$item->background }}" type="video/webm; codecs=&quot;vp8, vorbis&quot;">
                                <source src="{{ UPLOADS.'annuities/'.$item->background }}" type="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2&quot;">
                                <source src="{{ UPLOADS.'annuities/'.$item->background }}" type='video/ogg; codecs="theora, vorbis"'>
                            </video>
                        </div>
                    </div>
                @else
                    <div class="bg js_choice-bg" data-choice="{{ $item->id }}">
                        <div class="img" style="background-image: url('{{ UPLOADS.'annuities/'.$item->background }}')"></div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="sct-block sct-block--start js_step active" data-step="0">
            <div class="pwr">
                <div class="pct">
                    <h2 class="title-big animate">We help you find and compare annuity rates</h2>
                    <div class="choices animate">
                        @foreach ($annuities as $key => $item)
                            <?php 
                                $data_attributes = "";
                                $href = "";
                                if ($item->questions()->where('block', 0)->count() > 0){
                                    $data_attributes = "$item->id-1";
                                    $href = "javascript:void(0)";
                                }else{
                                    $data_attributes = "0";
                                    $href = RS.LANG."ranks/$item->alias";
                                }
                            ?>
                            <a href="{{ $href }}" class="choice js_btn-choice js_btn-step" data-choice="{{ $item->id }}" data-step="{{ $data_attributes }}">
                                <div class="wr">
                                    <div class="ct">
                                        <img src="{{ UPLOADS.'annuities/'.$item->preview }}" alt="" class="img">
                                        <h3 class="text">{{ $item->name }}</h3>
                                    </div>
                                </div>
                            </a>

                            @if ($key == count($annuities) - 1)
                                <?php 
                                    $default_annuity = $annuities->find(DEFAULT_ANNUITY_ID);
                                ?>
                                @if ($default_annuity)
                                    <a href="{{ RS.LANG."ranks/".$default_annuity->alias }}" class="choice js_btn-choice js_btn-step" data-choice="{{ $default_annuity->id }}" data-step="0">
                                        <div class="wr">
                                            <div class="ct">
                                                <img src="{{ IMG.'icons-general/icon4.svg' }}" alt="" class="img">
                                                <h3 class="text">All annuities</h3>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                                
                            @endif

                        @endforeach                        
                    </div>
                </div>
            </div>
        </div>

        @if ($questions->count() > 0)
            <?php 
                $cnt = 0; 
                $curr_annuity = $questions->first()->annuity_id; 
            ?>
            @foreach ($questions as $key => $question)
                @if ($question->answers()->count() > 0)
                    <?php 
                        $cnt ++;
                        $answers = $question->answers; 

                        if($curr_annuity != $question->annuity_id){
                            $cnt = 1;
                            $curr_annuity = $question->annuity_id;
                        }
                    ?>
                    <div class="sct-block sct-block--step js_step" data-annuity="{{$question->annuity_id}}" data-step="{{$question->annuity_id}}-{{ $cnt }}">
                        <div class="pwr">
                            <div class="pct">
                                <div class="step">
                                    <div class="main">
                                        <h4 class="title-big">{{ $question->question }}</h4>
                                        <div class="cols cols-3">
                                            @foreach ($answers as $answer)
                                                <div class="col"> 
                                                    <?php $alias = $question->annuity()->first()->alias; ?>
                                                    <a href="javascript:void(0)" onclick="network.answer('{{ $question->id }}', '{{ $answer->id }}', {{ $question->annuity_id }}, '{{$alias}}', this);" class="btn btn-step-value js_btn-step" data-step="{{ $question->annuity_id }}-{{$cnt + 1}}"><span>{{ $answer->answer }}</span></a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <footer class="footer">
                                        <?php 
                                            $prev_cnt = $cnt - 1;
                                            if($prev_cnt == 0){
                                                $prev_step = "0";  
                                                $prev_cnt = 0;                                              
                                            }else{
                                                $prev_step = "$question->annuity_id-$prev_cnt";
                                            }
                                            
                                        ?>
                                        <button class="btn btn-back icon icon-arrow-left js_btn-back" data-step="{{$prev_step}}">Back</button>
                                        <div class="choice-group">
                                            <img src="{{ UPLOADS.'annuities/'.$question->annuity()->first()->preview }}" alt="" class="img">
                                            <span class="name">{{ $question->annuity()->first()->name }}</span>
                                        </div>
                                    </footer>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif

        
{{-- 
        <div class="sct-block sct-block--step js_step" data-step="1-2">
            <div class="pwr">
                <div class="pct">
                    <div class="step">
                        <div class="main">
                            <h4 class="title-big">How long of a term?</h4>
                            <div class="cols cols-3">
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value"><span>30-year fixed</span></a>
                                </div>
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value"><span>20-year fixed</span></a>
                                </div>
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value"><span>15-year fixed</span></a>
                                </div>
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value"><span>10-year fixed</span></a>
                                </div>
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value"><span>see all</span></a>
                                </div>
                            </div>
                        </div>
                        <footer class="footer">
                            <button class="btn btn-back icon icon-arrow-left js_btn-back" data-step="1-1">Back</button>
                            <div class="choice-group">
                                <img src="{{ IMG.'icons-general/icon1.svg' }}" alt="" class="img">
                                <span class="name">Variable Annuities</span>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>

        <div class="sct-block sct-block--step js_step" data-step="2-1">
            <div class="pwr">
                <div class="pct">
                    <div class="step">
                        <div class="main">
                            <h4 class="title-big">What type of annuity?</h4>
                            <div class="cols cols-2">
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value"><span>Purchase</span></a>
                                </div>
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value"><span>Refinance</span></a>
                                </div>
                            </div>
                        </div>
                        <footer class="footer">
                            <button class="btn btn-back icon icon-arrow-left js_btn-back" data-step="0">Back</button>
                            <div class="choice-group">
                                <img src="{{ IMG.'icons-general/icon2.svg' }}" alt="" class="img">
                                <span class="name">Fixed Annuities</span>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div> --}}

    </section>
@endsection