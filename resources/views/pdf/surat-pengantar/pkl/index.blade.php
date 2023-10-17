<!DOCTYPE html>
<html lang="en" style="width: 21cm; height: 29cm; margin: 0px;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pengantar PKL</title>

    <style>
        .d-block {
            display: block;
        }
        .text-center {
            text-align: center;
        }
        .vertical-align-middle {
            vertical-align: middle;
        }
        .vertical-align-top {
            vertical-align: top;
        }
        .underline {
            text-decoration: underline;
        }
        .bold {
            font-weight: 700;
        }
        .bolder {
            font-weight: 900;
        }
        .w-100 {
            width: 100%;
        }
        .logo {
            height: auto;
            width: 100px;
        }
        .pb-10 {
            padding-bottom: 10px;
        }
        .py-10 {
            padding-bottom: 10px;
            padding-top: 10px;
        }
        .px-10 {
            padding-left: 10px;
            padding-right: 10px;
        }
        .px-50 {
            padding-left: 50px;
            padding-right: 50px;
        }
        .py-50 {
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .mt-20 {
            margin-top: 20px;
        }
        td:empty::after{
            content: "\00a0";
        }
    </style>
</head>
<body style="width: 21cm; height: 29cm; margin: 0px; position: relative; border: 1px solid red;">
    <div class="px-50 py-50">
        @include('pdf.partials.kop')

        <div class="px-50">
            <div class="w-100 mt-20">
                <table class="w-100">
                    <tr>
                        <td class="vertical-align-top" style="width: 50%;">
                            <table>
                                <tr>
                                    <td>Nomor</td>
                                    <td>:</td>
                                    <td class="bold">xxx/xxx/xxx/xx</td>
                                </tr>
                                <tr>
                                    <td>Klasifikasi</td>
                                    <td>:</td>
                                    <td>B I A S A</td>
                                </tr>
                                <tr>
                                    <td>Lampiran</td>
                                    <td>:</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Perihal</td>
                                    <td>:</td>
                                    <td class="bold underline">Praktek Kerja Lapangan</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="float: right;">
                                <tr>
                                    <td></td>
                                    <td>Surabaya, 30 Oktober 2023</td>
                                </tr>
                                <tr><td></td></tr>
                                <tr><td></td></tr>
                                <tr class="bold">
                                    <td></td>
                                    <td>Kepada :</td>
                                </tr>
                                <tr class="bold">
                                    <td>Yth.</td>
                                    <td>divisi</td>
                                </tr>
                                <tr class="bold">
                                    <td></td>
                                    <td>nama perusahaan</td>
                                </tr>
                                <tr class="bold">
                                    <td></td>
                                    <td>di Tempat</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
