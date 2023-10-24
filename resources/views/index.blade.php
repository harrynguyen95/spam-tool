<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Share Location</title>
    <meta name="csrf-token" content="{{ Session::token() }}">

    <link rel="icon" type="image/x-icon" href="{{ url('/favicon.ico') }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/favicon.ico') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">

    <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/styles.css') }}">
    <link rel="stylesheet" href="{{ url('/css/privacy.css') }}">
</head>

<body class="share-location">
    <main class="main">

        @include('header')

        <section class="privacy">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="thumbnail-privacy">
                            <img src="{{ url('/images/privacy.png') }}">
                        </div>
                        <div class="content-privacy">
                            <section>
                                <div>
                                    <div>
                                        <div>
                                            <div>
                                                <div>
                                                    <h2>Privacy Policy</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div><br></div>
                                    </div>
                                </div>
                            </section>
                            <section>
                                <div>
                                    <div>
                                        <div><br></div>
                                    </div>
                                    <div>
                                        <div>
                                            <div>
                                                <div>
                                                    <p><br></p>
                                                    <p>This SERVICE is provided by Us at no cost and is intended
                                                        for use as is.<br>This page is used to inform visitors
                                                        regarding my policies with the collection, use, and
                                                        disclosure of Personal Information if anyone decided to
                                                        use my Service.<br>If you choose to use my Service, then
                                                        you agree to the collection and use of information in
                                                        relation to this policy.<br>The Personal Information
                                                        that I collect is used for providing and improving the
                                                        Service.I will not use or share your information with
                                                        anyone except as described in this Privacy Policy.<br>–
                                                        Images: We are not responsible for the image content
                                                        created by users or searched on the internet.<br>–
                                                        Stories: User-generated stories in the app for
                                                        political, offensive, or deceptive purposes.<br>– We are
                                                        not responsible when users of the application for
                                                        malicious purposes, political purposes, vote, and
                                                        violate applicable national laws.<br><br><strong>1.
                                                            Information Collection and Use</strong><br>For a
                                                        better experience, while using our Service, I may
                                                        require you to provide us with certain personally
                                                        identifiable information.The information that I request
                                                        will be retained on your device and is not collected by
                                                        me in any way.<br>The app does use third party services
                                                        that may collect information used to identify
                                                        you.<br>Links to the privacy policies of third party
                                                        service providers can be used in the app<br>AdMob (dán
                                                        link
                                                        https://support.google.com/admob/answer/6128543?hl=en)<br><br><strong>2.
                                                            Log Data</strong><br>I want to inform you that
                                                        whenever you use my Service, in case of an error in the
                                                        app I collect data and information (through third party
                                                        products) on your phone called Log Data.<br>This Log
                                                        Data may include information such as your device
                                                        Internet Protocol (“IP”) address, device name, operating
                                                        system version, the configuration of the app when
                                                        utilizing my Service, the time and date of your use of
                                                        the Service, and other statistics.<br><br><strong>3.
                                                            Cookies</strong><br>Cookies are files with a small
                                                        amount of data that are commonly used as anonymous
                                                        unique identifiers.<br>These are sent to your browser
                                                        from the websites that you visit and are stored on your
                                                        device’s internal memory.<br>This Service does not use
                                                        these “cookies” explicitly. However, the app may use
                                                        third party code and libraries that use “cookies” to
                                                        collect information and improve their services.<br>You
                                                        have the option to either accept or refuse these cookies
                                                        and know when a cookie is being sent to your device. If
                                                        you choose to refuse our cookies, you may not be able to
                                                        use some portions of this Service.<br><br><strong>4.
                                                            Service Providers</strong><br>The permissions we use
                                                        in the
                                                        application:<br>android.permission.WRITE_EXTERNAL_STORAGE<br><br>android.permission.READ_EXTERNAL_STORAGE<br><br>android.permission.WAKE_LOCK<br><br>android.permission.VIBRATE<br><br>android.permission.INTERNET<br><br>android.permission.ACCESS_NETWORK_STATE<br><br>android.permission.RECEIVE_BOOT_COMPLETED<br><br>NOTE:<br>–
                                                        We are committed to using the above rights only for the
                                                        purpose of serving the function of the application and
                                                        fully comply with the policies of google play and not
                                                        for any other purpose.<br><br>– All information provided
                                                        by users will only be stored on their device and we do
                                                        not collect and store it in any form (including on
                                                        servers or on cloud services…).<br><br>– We do not
                                                        disclose, store or share any sensitive information of
                                                        users (email, bank account…).<br><br><strong>5. Service
                                                            Providers</strong><br>I may employ third-party
                                                        companies and individuals due to the following
                                                        reasons:<br>To facilitate our Service;<br><br>To provide
                                                        the Service on our behalf;<br><br>To perform
                                                        Service-related services;<br>To assist us in analyzing
                                                        how our Service is used.<br>I want to inform users of
                                                        this Service that these third parties have access to
                                                        your Personal Information.<br>The reason is to perform
                                                        the tasks assigned to them on our behalf.However, they
                                                        are obligated not to disclose or use the information for
                                                        any other purpose.<br><br><strong>6.
                                                            Security</strong><br>I value your trust in providing
                                                        us your Personal Information, thus we are striving to
                                                        use commercially acceptable means of protecting
                                                        it.<br>But remember that no method of transmission over
                                                        the internet, or method of electronic storage is 100%
                                                        secure and reliable, and I cannot guarantee its absolute
                                                        security.<br><br><strong>7. Links to Other
                                                            Sites</strong><br>This Service may contain links to
                                                        other sites. If you click on a third-party link, you
                                                        will be directed to that site.&nbsp;<br>Note that these
                                                        external sites are not operated by me.Therefore, I
                                                        strongly advise you to review the Privacy Policy of
                                                        these websites.<br><br>I have no control over and assume
                                                        no responsibility for the content, privacy policies, or
                                                        practices of any third-party sites or
                                                        services.<br><br><strong>8. Children’s
                                                            Privacy</strong><br>These Services do not address
                                                        anyone under the age of 13. I do not knowingly collect
                                                        personally identifiable information from children under
                                                        13.<br>In the case I discover that a child under 13 has
                                                        provided me with personal information, I immediately
                                                        delete this from our servers.<br>If you are a parent or
                                                        guardian and you are aware that your child has provided
                                                        us with personal information, please contact me so that
                                                        I will be able to take necessary
                                                        actions.<br><br><strong>9. Changes to This Privacy
                                                            Policy</strong><br>I may update our Privacy Policy
                                                        from time to time.Thus, you are advised to review this
                                                        page periodically for any changes.<br>I will notify you
                                                        of any changes by posting the new Privacy Policy on this
                                                        page.These changes are effective immediately after they
                                                        are posted on this page.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <br />
            <br />
        </section>
    </main>

    <div class="container-fluid" style="background-color: #f2f2f2">
        <div class="footer text-center">
            <p class="mb-0">Designed by Merryblue</p>
        </div>
    </div>

    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/jquery-3.7.1.min.js') }}"></script>
</body>

</html>
