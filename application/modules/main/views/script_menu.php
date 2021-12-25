<script>
    $(function() {
        getCart()
    });

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
                        <td><button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light" onclick="changeQty(${items.itemId}, 'less')"><i class="fas fa-minus"></i></button> &ensp;${items.qty} &ensp;<button type="button" class="btn btn-secondary btn-sm btn-rounded waves-effect waves-light" onclick="changeQty(${items.itemId}, 'add')"><i class="fas fa-plus"></i></button></td>
                        <td>${items.totalPriceCurrencyFormat}</td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light" onclick="deleteCart(${items.id})"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>`)
                })

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
</script>