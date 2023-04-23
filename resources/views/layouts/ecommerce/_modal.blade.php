    <!--modal popup start-->
    <div class="modal fade bd-example-modal-lg theme-modal" id="exampleModal" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body modal1">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-bg">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="offer-content"> <img
                                            src="{{ asset(websiteSettingMedia($type . '_modal')) }}"
                                            class="img-fluid
                                            blur-up lazyload"
                                            alt="">
                                        <h2>{{ app()->getLocale() == 'ar' ? websiteSettingAr($type . '_modal') : websiteSettingEn($type . '_modal') }}
                                        </h2>
                                        <h4 class="text-center m-2 b-2">
                                            {{ app()->getLocale() == 'ar' ? websiteSettingDAr($type . '_modal') : websiteSettingDEn($type . '_modal') }}
                                        </h4>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--modal popup end-->
