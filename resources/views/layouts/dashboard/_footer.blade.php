<footer class="footer">
    <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
        <div style="direction: ltr !important" class="col-12 col-sm-auto text-center">
            <p style="{{ app()->getLocale() == 'ar' ? 'direction:rtl' : '' }}" class="mb-0 text-600"><i
                    class="fa fa-copyright" aria-hidden="true"></i>
                {{ app()->getLocale() == 'ar' ? websiteSettingAr('copyright_text') : websiteSettingEn('copyright_text') }}
                <span> {{ ' - ' . __('Developed By') . ' ' }} <a style="color:#dd2027 !important;"
                        href="https://red-gulf.com/">RED</a></span>
            </p>
        </div>
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 text-600"></p>
        </div>
    </div>
</footer>
