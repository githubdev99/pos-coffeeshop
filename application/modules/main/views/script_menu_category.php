<script>
    $(function() {
        getItemCategory()

        $('form[name="addCategory"]').submit(function(e) {
            e.preventDefault();

            let data = formConvertObject($(this).serializeArray())

            var myHeaders = new Headers();
            myHeaders.append("Authorization", localStorage.getItem('token'));
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(data);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            fetch("http://localhost:3002/item/category", requestOptions)
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
                    } else if ((result.status.code === 404) || (result.status.code === 409)) {
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
                    } else {
                        show_alert({
                            type: typeAlert,
                            title: titleAlert,
                            timer: 2500,
                            message: result.status.message,
                        });

                        Object.keys(data).map((items) => {
                            $(`[name="${items}"]`).val("")
                        })

                        getItemCategory()
                        closeAddCategory()
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

        $('form[name="editCategory"]').submit(function(e) {
            e.preventDefault();

            let data = formConvertObject($(this).serializeArray())

            var myHeaders = new Headers();
            myHeaders.append("Authorization", localStorage.getItem('token'));
            myHeaders.append("Content-Type", "application/json");

            var raw = JSON.stringify(data);

            var requestOptions = {
                method: 'PUT',
                headers: myHeaders,
                body: raw,
                redirect: 'follow'
            };

            fetch(`http://localhost:3002/item/category/${data.id}`, requestOptions)
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
                    } else if ((result.status.code === 404) || (result.status.code === 409)) {
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
                    } else {
                        show_alert({
                            type: typeAlert,
                            title: titleAlert,
                            timer: 2500,
                            message: result.status.message,
                        });

                        Object.keys(data).map((items) => {
                            $(`[name="${items}"]`).val("")
                        })

                        getItemCategory()
                        closeEditCategory()
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
    });

    const getItemCategory = () => {
        let listCategory = $('#listCategory').DataTable()
        listCategory.clear().draw();

        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("http://localhost:3002/item/category?isList=1&filterCategory=", requestOptions)
            .then(response => response.json())
            .then(result => {
                result.data.map((items) => {
                    listCategory.row.add([
                        `${items.name}`,
                        `<div class="square-switch">
                            <input type="checkbox" id="square-switch${items.id}" onclick="changeStatusItemCategory(${items.id})" switch="none" ${(items.isActive) ? `checked` : ``} />
                            <label for="square-switch${items.id}" data-on-label="On"
                                data-off-label="Off"></label>
                        </div>`,
                        `<button type="button" class="btn btn-info btn-rounded waves-effect waves-light" onclick="showEditCategory(${items.id})"><i class="fas fa-edit"></i></button>`,
                    ]).draw(false);
                })
            })
            .catch(error => {
                show_alert({
                    type: 'error',
                    title: 'Error!',
                    timer: 2500,
                    message: error
                });
            });
    }

    const changeStatusItemCategory = (id) => {
        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));

        var requestOptions = {
            method: 'PUT',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch(`http://localhost:3002/item/category/status/${id}`, requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.status.code === 200) {
                    getItemCategory()
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
    }

    const showAddCategory = () => {
        $('#addCategory').modal('show')
    }

    const closeAddCategory = () => {
        $('#addCategory').modal('hide')
    }

    const showEditCategory = (id) => {
        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch(`http://localhost:3002/item/category/${id}`, requestOptions)
            .then(response => response.json())
            .then(result => {
                $('#editCategory [name="id"]').val(result.data.id)
                $('#editCategory [name="name"]').val(result.data.name)

                $('#editCategory').modal('show')
            })
            .catch(error => {
                show_alert({
                    type: 'error',
                    title: 'Error!',
                    timer: 2500,
                    message: error
                });
            });
    }

    const closeEditCategory = () => {
        $('#editCategory').modal('hide')
    }
</script>