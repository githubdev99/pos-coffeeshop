<script>
    $(document).ready(function () {
        select2_ajax({
            selector: 'select[name="provinsi"]',
            url: '<?= base_url() ?>json/option_provinsi'
        });

        $('select[name="provinsi"]').change(function (e) {
            e.preventDefault();
            
            if ($(this).val()) {
                $('select[name="kota_kabupaten"]').html(new Option('Pilih Kota/Kabupaten', '', false, false)).trigger('change');
                $('select[name="kecamatan"]').html(new Option('Pilih Kecamatan', '', false, false)).trigger('change').select2();
                $('select[name="kelurahan"]').html(new Option('Pilih Kelurahan', '', false, false)).trigger('change').select2();

                select2_ajax({
                    selector: 'select[name="kota_kabupaten"]',
                    url: '<?= base_url() ?>json/option_kota',
                    data: {
                        province_id: $(this).val()
                    }
                });
            }
        });

        $('select[name="kota_kabupaten"]').change(function (e) {
            e.preventDefault();
            
            if ($(this).val()) {
                $('select[name="kecamatan"]').html(new Option('Pilih Kecamatan', '', false, false)).trigger('change');
                $('select[name="kelurahan"]').html(new Option('Pilih Kelurahan', '', false, false)).trigger('change').select2();

                select2_ajax({
                    selector: 'select[name="kecamatan"]',
                    url: '<?= base_url() ?>json/option_kecamatan',
                    data: {
                        city_id: $(this).val()
                    }
                });
            }
        });

        $('select[name="kecamatan"]').change(function (e) {
            e.preventDefault();
            
            if ($(this).val()) {
                $('select[name="kelurahan"]').html(new Option('Pilih Kelurahan', '', false, false)).trigger('change');

                select2_ajax({
                    selector: 'select[name="kelurahan"]',
                    url: '<?= base_url() ?>json/option_kelurahan',
                    data: {
                        kd_kec: $(this).val().split(':')[1]
                    }
                });
            }
        });

        $('form[name="buka_toko"]').submit(function (e) {
            e.preventDefault();
            
            var active_element = $(document.activeElement);

            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize()+'&submit='+active_element.val(),
                dataType: "json",
                success: function (response) {
                    if (response.error == true) {
                        Swal.mixin({
                            toast: true,
                            position: "top",
                            showCloseButton: !0,
                            showConfirmButton: false,
                            timer: 4000,
                            onOpen: (toast) => {
                                toast.addEventListener("mouseenter", Swal.stopTimer)
                                toast.addEventListener("mouseleave", Swal.resumeTimer)
                            }
                        }).fire({
                            icon: response.type,
                            title: response.message
                        });
                    } else {
                        Swal.mixin({
                            toast: true,
                            position: "top",
                            showCloseButton: !0,
                            showConfirmButton: false,
                            timer: 2000
                        }).fire({
                            icon: response.type,
                            title: response.message
                        }).then(function() {
                            window.location = response.callback;
                        });

                        $('button[name="'+active_element.val()+'"]').attr('disabled', 'true');
                        $('button[name="'+active_element.val()+'"]').html('<i class="fas fa-circle-notch fa-spin"></i>');
                    }
                }
            });
        });
    });
</script>