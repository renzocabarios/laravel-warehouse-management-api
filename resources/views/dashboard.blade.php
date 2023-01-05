@extends('master')

@section('content')
    <div class="container">
        <label for="years">Choose a year:</label>

        <select name="years" id="years" class="years">
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="mercedes">Mercedes</option>
            <option value="audi">Audi</option>
        </select>

        <div class="row row-cols-1 row-cols-md-2 align-items-md-center">
            <canvas id="shipment"></canvas>
            <canvas id="branch"></canvas>
            <canvas id="user"></canvas>
        </div>
    </div>
@endsection()

@push('scripts')
    <script>
        function generateArrayOfYears() {
            var max = new Date().getFullYear()
            var min = max - 9
            var years = []

            for (var i = max; i >= min; i--) {
                years.push(i)
            }
            return years
        }

        $(document).ready(() => {

            $('.years').on('change', function(value) {
                alert(this.value);
                var tempValue = this.value;
                (async function() {
                    $.ajax({
                        type: "GET",
                        dataType: 'json',
                        url: `/api/shipment`,
                        success: function(data) {

                            var yearShipments = data.data.filter(row => {
                                return new Date(row.created_at).getFullYear() ==
                                    parseInt(tempValue);
                            })

                            if (data.status != "failed") {
                                new Chart(
                                    document.getElementById('shipment').getContext(
                                        '2d'), {
                                        type: 'bar',
                                        data: {
                                            labels: moment.months(),
                                            datasets: [{
                                                label: 'Shipment',
                                                data: moment.months().map((
                                                    month,
                                                    index) => {
                                                    return yearShipments
                                                        .filter(
                                                            row => {
                                                                return new Date(
                                                                        row
                                                                        .created_at
                                                                    )
                                                                    .getMonth() ==
                                                                    index
                                                            }
                                                        )
                                                        .length
                                                })
                                            }]
                                        }
                                    }
                                );
                            }
                        },
                        error: function(data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    });


                    $.ajax({
                        type: "GET",
                        dataType: 'json',
                        url: `/api/branch`,
                        success: function(data) {

                            var yearBranches = data.data.filter(row => {
                                return new Date(row.created_at).getFullYear() ==
                                    parseInt(tempValue);
                            })
                            if (data.status != "failed") {
                                new Chart(
                                    document.getElementById('branch').getContext(
                                        '2d'), {
                                        type: 'bar',
                                        data: {
                                            labels: moment.months(),
                                            datasets: [{
                                                label: 'branch',
                                                data: moment.months().map((
                                                    month,
                                                    index) => {
                                                    return yearBranches
                                                        .filter(
                                                            row =>
                                                            new Date(
                                                                row
                                                                .created_at
                                                            )
                                                            .getMonth() ==
                                                            index
                                                        )
                                                        .length
                                                })
                                            }]
                                        }
                                    }
                                );
                            }
                        },
                        error: function(data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    });

                    $.ajax({
                        type: "GET",
                        dataType: 'json',
                        url: `/api/user`,
                        success: function(data) {


                            if (data.status != "failed") {

                                var yearUsers = data.data.filter(row => {
                                    return new Date(row.created_at)
                                        .getFullYear() ==
                                        parseInt(tempValue);
                                })
                                new Chart(
                                    document.getElementById('user').getContext(
                                        '2d'), {
                                        type: 'bar',
                                        data: {
                                            labels: moment.months(),
                                            datasets: [{
                                                label: 'user',
                                                data: moment.months().map((
                                                    month,
                                                    index) => {
                                                    return yearUsers
                                                        .filter(
                                                            row =>
                                                            new Date(
                                                                row
                                                                .created_at
                                                            )
                                                            .getMonth() ==
                                                            index
                                                        )
                                                        .length
                                                })
                                            }]
                                        }
                                    }
                                );
                            }
                        },
                        error: function(data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    });



                })();
            });

            $('.years').empty()
            $('.years').append(generateArrayOfYears().map(e => {
                return `<option value="${e}">${e}</option>`
            }).reduce(
                (accumulator, currentValue) => accumulator + currentValue,
                ""
            ));


            console.log(generateArrayOfYears());
            (async function() {
                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: `/api/shipment`,
                    success: function(data) {
                        if (data.status != "failed") {
                            new Chart(
                                document.getElementById('shipment').getContext('2d'), {
                                    type: 'bar',
                                    data: {
                                        labels: moment.months(),
                                        datasets: [{
                                            label: 'Shipment',
                                            data: moment.months().map((month,
                                                index) => {
                                                return data.data.filter(
                                                        row =>
                                                        new Date(row
                                                            .created_at)
                                                        .getMonth() == index
                                                    )
                                                    .length
                                            })
                                        }]
                                    }
                                }
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });


                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: `/api/branch`,
                    success: function(data) {
                        if (data.status != "failed") {
                            new Chart(
                                document.getElementById('branch').getContext('2d'), {
                                    type: 'bar',
                                    data: {
                                        labels: moment.months(),
                                        datasets: [{
                                            label: 'branch',
                                            data: moment.months().map((month,
                                                index) => {
                                                return data.data.filter(
                                                        row =>
                                                        new Date(row
                                                            .created_at)
                                                        .getMonth() == index
                                                    )
                                                    .length
                                            })
                                        }]
                                    }
                                }
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });

                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: `/api/user`,
                    success: function(data) {
                        if (data.status != "failed") {
                            new Chart(
                                document.getElementById('user').getContext('2d'), {
                                    type: 'bar',
                                    data: {
                                        labels: moment.months(),
                                        datasets: [{
                                            label: 'user',
                                            data: moment.months().map((month,
                                                index) => {
                                                return data.data.filter(
                                                        row =>
                                                        new Date(row
                                                            .created_at)
                                                        .getMonth() == index
                                                    )
                                                    .length
                                            })
                                        }]
                                    }
                                }
                            );
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });



            })();
        });
    </script>
@endpush
