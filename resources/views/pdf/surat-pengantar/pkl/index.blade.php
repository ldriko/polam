@php
    $data = json_decode($submission->data, true)
@endphp

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
        .capitalize {
            text-transform: capitalize;
        }
        .text-center {
            text-align: center;
        }
        .text-justify {
            text-align: justify;
        }
        .text-indent {
            text-indent: 30px;
        }
        .lh-1-5 {
            line-height: 1.5;
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
        .w-50 {
            width: 50%;
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
        .mt-50 {
            margin-top: 50px;
        }
        td:empty::after{
            content: "\00a0";
        }
        .ttd {
            width: 200px;
            height: auto;
        }
    </style>
</head>
<body style="width: 21cm; height: 29cm; margin: 0px; position: relative;">
    <div class="px-50 py-50">
        @include('pdf.partials.kop')

        <section class="px-50 mt-20">
            <table class="w-100">
                <tr>
                    <td class="vertical-align-top" style="width: 50%;">
                        <table>
                            <tr>
                                <td>Nomor</td>
                                <td>:</td>
                                <td class="bold">{{ $submission->formattedLetterNumber }}</td>
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
                                <td>Surabaya, {{ Carbon\Carbon::parse($submission->approved_at)->locale('id_ID')->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr><td></td></tr>
                            <tr><td></td></tr>
                            <tr class="bold">
                                <td></td>
                                <td>Kepada :</td>
                            </tr>
                            <tr class="bold">
                                <td>Yth.</td>
                                <td>{{ $data['company_division'] }}</td>
                            </tr>
                            <tr class="bold">
                                <td></td>
                                <td>{{ $data['company_name'] }}</td>
                            </tr>
                            <tr class="bold">
                                <td></td>
                                <td>di Tempat</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </section>

        <section class="px-50 mt-50">
            <p class="text-justify text-indent lh-1-5">Dalam rangka menunjang kegiatan Akademik Mahasiswa Fakultas Ilmu Komputer Universitas Pembangunan Nasional "Veteran" Jawa Timur, yang melaksanakan Praktek Kerja Lapangan.</p>
            <p class="text-justify text-indent lh-1-5">Sehubungan dengan kegiatan tersebut, maka dengan ini diajukan mahasiswa Fakultas Ilmu Komputer <span class="bold underline capitalize">Program Studi {{ $submission->user->department->name }}</span> yang bernama:</p>
            <table class="w-100">
                @foreach ($data['name'] as $key => $name)
                    @if ($name != null && $data['registration_number'][$key] != null)
                        <tr class="bold text-center">
                            <td>{{ $name }}</td>
                            <td>NPM. {{ $data['registration_number'][$key] }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>
            <p class="text-justify text-indent lh-1-5">Mohon diberi ijin untuk keperluan pengumpulan data untuk referensi tugas Praktek Kerja Lapangan. Demikian atas kerja samanya, disampaikan terima kasih.</p>
        </section>

        <section class="px-50 mt-50">
            <table class="w-100">
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td class="bold">Dekan</td>
                </tr>
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td class="bold">Fakultas Ilmu Komputer</td>
                </tr>
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td><img class="ttd" src="{{ $submission->approvedByEmployee->signatureImage }}" alt="ttd"></td>
                </tr>
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td class="bold underline">{{ $submission->approvedByEmployee->name }}</td>
                </tr>
                <tr class="text-center">
                    <td class="w-50"></td>
                    <td class="bold">{{ $submission->approvedByEmployee->registration_type }}. {{ $submission->approvedByEmployee->registration_number }}</td>
                </tr>
            </table>
        </section>
    </div>
</body>
</html>
