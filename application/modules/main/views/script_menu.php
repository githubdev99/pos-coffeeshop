<script>
    $(function() {
        getCategory()
        getMenu()
        getCart()

        $('form[name="addCheckout"]').submit(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi',
                text: "Anda yakin ingin melakukan checkout ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
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

                    fetch("http://localhost:3002/bill/checkout", requestOptions)
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

                                getCategory()
                                getMenu()
                                getCart()
                                closeAddCheckout()
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
            })
        });
    });

    const getCategory = (filterCategory = '') => {
        let listCategory = []

        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch(`http://localhost:3002/item/category?isList=0&filterCategory=${filterCategory}`, requestOptions)
            .then(response => response.json())
            .then(result => {
                listCategory.push(`
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link ${(filterCategory === '') ? 'active' : ''}" data-bs-toggle="tab" href="#category0" role="tab" onclick="getCategory()">
                        <span class="d-none d-sm-block">Semua</span>
                    </a>
                </li>`)

                result.data.map((items, index) => {
                    listCategory.push(`
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link ${(items.isSelected) ? 'active' : ''}" data-bs-toggle="tab" href="#category${items.id}" role="tab" onclick="getCategory(${items.id})">
                            <span class="d-none d-sm-block">${items.name}</span>
                        </a>
                    </li>`)
                })

                getMenu(filterCategory)

                $('#listCategory').html(listCategory)
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

    const getMenu = (filterCategory = '') => {
        let listMenu = []

        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch(`http://localhost:3002/item?isList=0&filterCategory=${filterCategory}`, requestOptions)
            .then(response => response.json())
            .then(result => {
                if (result.data.length) {
                    result.data.map((items, index) => {
                        listMenu.push(`
                        <div class="col-xl-4 col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="product-img position-relative">
                                        <img src="${items.image}" alt="" class="img-fluid mx-auto d-block img-thumbnail">
                                    </div>
                                    <div class="mt-4 text-center">
                                        <h5 class="text-truncate"><span class="text-dark">${items.name}</span></h5>
                                        <span class="mb-3 text-muted"><i>${items.category.name}</i></span>
                                        <h5 class="mt-2"> <b>${items.priceCurrencyFormat}</b></h5>
                                        <span class="mb-3 text-muted">Stok Tersedia : ${items.stock}</span>
                                        <button type="button" class="btn btn-info waves-effect mt-3" onclick="addCart(${items.id})">Tambah ke keranjang</button>
                                    </div>
                                </div>
                            </div>
                        </div>`)
                    })
                } else {
                    listMenu.push(`
                    Menu belum tersedia...`)
                }

                $('#listMenu').html(listMenu)
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

    const getCart = () => {
        let listCart = []

        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("http://localhost:3002/cart", requestOptions)
            .then(response => response.json())
            .then(result => {
                result.data.items.map((items, index) => {
                    listCart.push(`
                    <tr>
                        <td>${++index}</td>
                        <td>${items.name}<br><br>${items.priceCurrencyFormat}</td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light" onclick="changeQty(${items.itemId}, 'less')"><i class="fas fa-minus"></i></button> &ensp;${items.qty} &ensp;<button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light" onclick="changeQty(${items.itemId}, 'add')"><i class="fas fa-plus"></i></button>
                        </td>
                        <td>${items.totalPriceCurrencyFormat}</td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light" onclick="deleteCart(${items.id})"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>`)
                })

                $('#totalQty').html(result.data.totalQty)
                $('#totalPrice').html(result.data.totalPriceCurrencyFormat)
                $('#listCart').html(listCart)
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

    const deleteCart = (id) => {
        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));

        var requestOptions = {
            method: 'DELETE',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch(`http://localhost:3002/cart/${id}`, requestOptions)
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

                    getCart()
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

    const changeQty = (itemId, action) => {
        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify({
            "itemId": itemId,
            "qty": 0,
        });

        var requestOptions = {
            method: 'PUT',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch(`http://localhost:3002/cart/qty/${action}`, requestOptions)
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
                    show_alert({
                        type: typeAlert,
                        title: titleAlert,
                        timer: 2500,
                        message: result.status.message
                    });
                } else {
                    getCart()
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

    const addCart = (itemId) => {
        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify({
            "itemId": itemId,
            "qty": "1"
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("http://localhost:3002/cart", requestOptions)
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

                    getCart()
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

    const showAddCheckout = () => {
        $('#addCheckout').modal('show')
    }

    const closeAddCheckout = () => {
        $('#addCheckout').modal('hide')
    }
</script>