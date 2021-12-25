<script>
    trigger_enter({
        selector: '.login',
        target: 'button[name="login"]'
    });

    $('form[name="login"]').submit(function(e) {
        e.preventDefault();

        let activeElement = document.activeElement;
        let textButton = activeElement.textContent;

        $('button[name="' + activeElement.name + '"]').attr('disabled', 'true');
        $('button[name="' + activeElement.name + '"]').html(`Loading...`);

        let data = formConvertObject($(this).serializeArray())

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify(data);

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("http://localhost:3002/auth/login", requestOptions)
            .then(response => response.json())
            .then(result => {
                let typeAlert = ''
                let titleAlert = ''
                if (result.status.code === 200) {
                    typeAlert = 'success'
                    titleAlert = 'Successfull!'
                } else if ((result.status.code === 400) || (result.status.code === 401)) {
                    typeAlert = 'error'
                    titleAlert = 'Failed!'
                } else if (result.status.code === 404) {
                    typeAlert = 'warning'
                    titleAlert = 'Warning!'
                }

                if (result.status.code !== 200) {
                    Object.keys(data).map((items) => {
                        $(`.body-${items}`).html("")
                    })

                    result.errors.map((items) => {
                        $(`.body-${items.location}`).html(items.text)
                    })

                    show_alert({
                        type: typeAlert,
                        title: titleAlert,
                        timer: 2500,
                        message: result.status.message
                    });

                    $('button[name="' + activeElement.name + '"]').removeAttr('disabled');
                    $('button[name="' + activeElement.name + '"]').html(textButton);
                } else {
                    show_alert({
                        type: typeAlert,
                        title: titleAlert,
                        timer: 2500,
                        message: result.status.message,
                        callback: `<?= base_url() ?>`,
                    });

                    localStorage.setItem('token', result.data)
                }
            })
            .catch(error => {
                show_alert({
                    type: 'error',
                    title: 'Error!',
                    timer: 2500,
                    message: error
                });
            });
    });
</script>