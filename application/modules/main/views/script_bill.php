<script>
    $(function() {
        getBill()
    });

    const getBill = () => {
        let listBill = $('#listBill').DataTable()
        listBill.clear().draw();

        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("http://localhost:3002/bill", requestOptions)
            .then(response => response.json())
            .then(result => {
                result.data.map((items, index) => {
                    listBill.row.add([
                        `${++index}`,
                        `${items.bill}`,
                        `${items.customerName}`,
                        `${items.totalPriceCurrencyFormat}`,
                        `<button type="button" class="btn btn-info btn-rounded waves-effect waves-light" onclick="showDetail(${items.id})"><i class="fas fa-info"></i></button>`,
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

    const showDetail = (id) => {
        var myHeaders = new Headers();
        myHeaders.append("Authorization", localStorage.getItem('token'));

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch(`http://localhost:3002/bill/${id}`, requestOptions)
            .then(response => response.json())
            .then(result => {
                $('#bill').html(result.data.bill)
                $('#customerName').html(result.data.customerName)

                let billDetailItems = []
                result.data.items.map((items, index) => {
                    billDetailItems.push(`
                    <tr>
                        <td>${++index}</td>
                        <td><img class="img-thumbnail" alt="200x200" src="${items.image}" data-holder-rendered="true" width="100"></td>
                        <td>${items.name}</td>
                        <td>${items.qty}</td>
                        <td>${items.priceCurrencyFormat}</td>
                        <td>${items.totalPriceCurrencyFormat}</td>
                    </tr>`)
                })

                $('#billDetailItems').html(billDetailItems)
                $('#billDetail').modal('show')
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