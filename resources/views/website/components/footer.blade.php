<footer id="footer">
    <div class="footer_inner no_fill footer-light ext_view">
        <div class="bottom_wrapper">
            <div class="wrapper_inner">
                <div class="row bottom-middle">
                    <div class="col-md-7">
                        <div class="row">
                            @foreach($footerSections as $fsection)
                            <div class="col-md-4 col-sm-4">
                                <div class="bottom-menu">
                                    <div class="items">
                                        <div class="item-link">
                                            <div class="item">
                                                <div class="title">
                                                    <span>{{ $fsection->translate(app()->getlocale())->title }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wrap">
                                            @foreach($fsection->children as $children)
                                            <div class="item-link">
                                                <div class="item">
                                                    <div class="title">
                                                        <a href="/{{ $children->getFullSlug() ?? '' }}">
                                                            {{ $children->translate(app()->getlocale())->title }} </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                           
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-4 col-sm-offset-2">
                        <div class="info contacts_block_footer">
                        <span class="white_middle_text">
                                                                            კონტაქტი                                                </span>
                     
                        <div class="email blocks">
                        <a href="#"><span class="__cf_email__">info@ideal.ge</span></a>
                        </div>
                        <div class="address blocks">
                        <b>თბილისი:</b> დ. აღმაშენებლის ხეივანი N71<br>
                        <b>ბათუმი:</b> ქ.ბათუმი. ლეონიძის ქ.N7												</div>
                        </div>
                        </div>
                </div>
                <div class="bottom-under">
                    <div class="row">
                        <div class="col-md-12 outer-wrapper">
                            <div class="inner-wrapper row">
                                <div class="copy-block">
                                    <div class="copy">
                                        © Copyright. All rights reserved.
                                    </div>
                                    <!--<div class="blocks">
                                                    <a href="/ka/შეთანხმების-პირობები">
                                                        შეთანხმების პირობები
                                                    </a>
                                                </div>
                                                <div class="blocks">
                                                    <a href="/ka/კონფიდენციალურობის-პოლიტიკა">
                                                        კონფიდენციალურობის პოლიტიკა
                                                    </a>
                                                </div>-->
                                </div>
                            </div>
                        </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>