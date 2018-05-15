@extends('layouts.default')

@section('content')
    <section class="psc psc-main">
        <div class="sct-bg">
            <div class="bg active js_choice-bg" data-choice="0">
             <div class="img" style="background-image: url('{{ IMG.'content/bg0.jpg' }}')"></div>
            </div>
            <div class="bg js_choice-bg" data-choice="1">
                <div class="img" style="background-image: url('{{ IMG.'content/bg1.jpg' }}')"></div>
            </div>
            <div class="bg js_choice-bg" data-choice="2">
                <div class="img" style="background-image: url('{{ IMG.'content/bg2.jpg' }}')">
                    <video loop="" muted="">
                        <source src="assets/video/video1.webm" type="video/webm; codecs=&quot;vp8, vorbis&quot;">
                        <source src="assets/video/video1.mp4" type="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2&quot;">
                    </video>
                </div>
            </div>
            <div class="bg js_choice-bg" data-choice="3">
                <div class="img" style="background-image: url('{{ IMG.'content/bg3.jpg' }}')"></div>
            </div>
            <div class="bg js_choice-bg" data-choice="4">
                <div class="img" style="background-image: url('{{ IMG.'content/bg4.jpg' }}')"></div>
            </div>
        </div>

        <div class="sct-block sct-block--start js_step active" data-step="0">
            <div class="pwr">
                <div class="pct">
                    <h2 class="title-big animate">We help you find and compare annuity rates</h2>
                    <div class="choices animate">
                        @foreach ($annuities as $key => $item)
                            <a href="javascript:void(0)" class="choice js_btn-choice js_btn-step" data-choice="1" data-step="1-1">
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
                                    <a href="javascript:void(0)" class="choice js_btn-choice js_btn-step" data-choice="4" data-step="4-1">
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

        <div class="sct-block sct-block--step js_step" data-step="1-1">
            <div class="pwr">
                <div class="pct">
                    <div class="step">
                        <div class="main">
                            <h4 class="title-big">What type of annuity?</h4>
                            <div class="cols cols-3">
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value js_btn-step" data-step="1-2"><span>Purchase</span></a>
                                </div>
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value"><span>Refinance</span></a>
                                </div>
                                <div class="col">   
                                    <a href="javascript:void(0)" class="btn btn-step-value"><span>Home equity</span></a>
                                </div>
                            </div>
                        </div>
                        <footer class="footer">
                            <button class="btn btn-back icon icon-arrow-left js_btn-back" data-step="0">Back</button>
                            <div class="choice-group">
                                <img src="{{ IMG.'icons-general/icon1.svg' }}" alt="" class="img">
                                <span class="name">Variable Annuities</span>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>

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
        </div>

    </section>
@endsection