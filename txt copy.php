{
    "status": true,
    "message": "Data berhasil diambil",
    "results": {
        "info": [
            {
                "name": "Kode Kejadian",
                "value": "CC1_0000018766"
            },
            {
                "name": "Nama Pelapor",
                "value": "Ibu Nayla"
            }
        ],
        "data": [
            {
                "name": "alamat",
                "label": "Alamat Kejadian",
                "type": "textarea",
                "value": "Jl. Arjuna Selatan Arteri Tol, Kel. Kebon Jeruk, Kec.Kebon Jeruk Jakarta Barat",
                "mandatory": true
            },
            {
                "name": "rt",
                "label": "RT",
                "type": "number",
                "value": "01",
                "mandatory": true
            },
            {
                "name": "rw",
                "label": "RW",
                "type": "number",
                "value": "01",
                "mandatory": true
            },
            {
                "name": "objek_kejadian_awal",
                "label": "Objek Kejadian Awal",
                "type": "text",
                "value": "Lakalantas ",
                "mandatory": true
            },
            {
                "name": "sebab_kejadian",
                "label": "Sebab Kejadian",
                "type": "select",
                "value": "Lainnya",
                "options": [
                    {
                        "id": "a",
                        "name": "nama"
                    },
                    {
                        "id": "b",
                        "name": "nama b"
                    }
                ]
            },
            {
                "name": "keterangan_sebab",
                "label": "Keterangan Kejadian",
                "type": "text",
                "value": "Lakalantas",
                "mandatory": true
            },
            {
                "name": "laporan_berita",
                "label": "Kronologis",
                "type": "textarea",
                "value": "Pelapor datang ke kantor sektor kebun jeruk melaporkan kejadian lakalantas tunggal tepat di depan new beringin motor pinggir tol",
                "mandatory": true
            },
            {
                "name": "kendala",
                "label": "Kendala",
                "type": "textarea",
                "value": "Nihil",
                "mandatory": true
            },
            {
                "name": "luas_area",
                "label": "Luas Area Terbakar (m2)",
                "type": "number",
                "value": "0",
                "mandatory": true
            },
            {
                "title": "Korban Petugas",
                "type": "summary_korban",
                "forms": [
                    {
                        "name": "petugas_meninggal",
                        "label": "Petugas Meninggal",
                        "type": "number",
                        "readonly": false,
                        "value": "0",
                        "mandatory": true
                    },
                    {
                        "name": "petugas_luka_ringan",
                        "label": "Petugas Luka Ringan",
                        "type": "number",
                        "readonly": false,
                        "value": "1",
                        "mandatory": true
                    },
                    {
                        "name": "luas_area",
                        "label": "Petugas Luka Berat",
                        "type": "number",
                        "readonly": false,
                        "value": "0",
                        "mandatory": true
                    }
                ]
            },
            {
                "title": "Korban Masyarakat",
                "type": "summary_korban",
                "forms": [
                    {
                        "name": "masyarakat_meninggal",
                        "label": "Masyarakat Meninggal",
                        "type": "number",
                        "value": "0",
                        "mandatory": true
                    },
                    {
                        "name": "masyarakat_luka",
                        "label": "Masyarakat Luka",
                        "type": "number",
                        "value": "1",
                        "mandatory": true
                    }
                ]
            },
            {
                "name": "jumlah_KK",
                "label": "Jumlah KK",
                "type": "number",
                "value": "0",
                "mandatory": true
            },
            {
                "name": "jumlah_jiwa",
                "label": "Jumlah Jiwa",
                "type": "number",
                "value": "1",
                "mandatory": true
            },
            {
                "name": "foto1",
                "label": "Jumlah Jiwa",
                "type": "image",
                "value": "1",
                "mandatory": true
            },
            {
                "name": "foto2",
                "label": "Jumlah Jiwa",
                "type": "image",
                "value": "1",
                "mandatory": true
            },
            {
                "name": "foto3",
                "label": "Jumlah Jiwa",
                "type": "image",
                "value": "1",
                "mandatory": true
            },
            {
                "title": "Taksiran Kerugian",
                "type": "taksiran_kerugian",
                "forms": [
                    {
                        "name": "bp",
                        "label": "BP",
                        "type": "number",
                        "value": "0",
                        "mandatory": true
                    },
                    {
                        "title": "BUP",
                        "type": "summary_kerugian",
                        "forms": [
                            {
                                "name": "rumah",
                                "label": "Rumah",
                                "type": "number",
                                "value": "0",
                                "mandatory": true
                            },
                            {
                                "title": "Ruko",
                                "type": "summary_kerugian",
                                "forms": [
                                    {
                                        "name": "bup",
                                        "label": "BUP",
                                        "type": "number",
                                        "value": "0",
                                        "mandatory": true
                                    },
                                    {
                                        "name": "bup",
                                        "label": "BUP",
                                        "type": "number",
                                        "value": "0",
                                        "mandatory": true
                                    }
                                ]
                            }
                        ]
                    }
                ]
            }
        ]
    }
}