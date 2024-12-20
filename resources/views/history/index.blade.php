@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css">
@endpush

@section('content')
    <div class="flex justify-center p-4 lg:min-h-[calc(100vh-140px)] max-md:min-h-[calc(100vh-139px)] overflow-hidden">
        <div class="p-4 bg-white border rounded-lg lg:w-4/5 max-md:w-full">
            <h1 class="lg:text-2xl max-md:text-xl font-semibold tracking-wide mb-4 text-center">Book Loan History</h1>

            <div class="overflow-x-auto">
                <table id="loan" class="min-w-full">
                    <thead>
                        <tr>
                            <td>No.</td>
                            <td>Book</td>
                            <td>Start Date</td>
                            <td>End Date</td>
                            <td>Return Date</td>
                            <td>Status</td>
                            <td>Actions</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.tailwindcss.js"></script>

    <script>
        $(document).ready(function() {
            var table = new DataTable('#loan', {
                processing: true,
                paging: true,
                responsive: true,
                serverSide: true,
                searching: true,
                ordering: true,
                ajax: {
                    url: route('loan.index'),
                    type: 'GET'
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'book.name',
                        name: 'book.name'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'return_date',
                        name: 'return_date'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            let status = '';

                            if (data == 1) {
                                status =
                                    '<span class="badge badge-sm badge-error text-white p-3">Pending</span>'
                            } else if (data == 2) {
                                status =
                                    '<span class="badge badge-sm badge-success text-white p-3">Approved</span>'
                            } else {
                                status =
                                    '<span class="badge badge-sm badge-primary text-white p-3">Completed</span>'
                            }

                            return status;
                        }
                    },
                    {
                        data: 'rating',
                        name: 'rating',
                        render: function(data, type, row) {
                            if (data) {
                                return `
                                    <a href="javascript:void(0);" data-id="${row.book_id}"
                                        class="flex items-center justify-center text-white rounded-md text-sm p-1.5 bg-primary hover:bg-primary transition rate-btn gap-1">
                                        <i class="fa-solid fa-star text-xs"></i> Rate
                                    </a>
                                `;
                            } else {
                                return '';
                            }
                        }
                    }
                ],
                columnDefs: [{
                    targets: [-1, 0],
                    orderable: false,
                    searchable: false,
                }]
            });

            $(document).on('click', '.rate-btn', function() {
                const id = $(this).data('id');

                let selectedRating = 0;

                swal.fire({
                    title: 'Rate Book',
                    html: `
                        <div style="font-size: 2rem;">
                            <i class="fa fa-star" data-rate="1"></i>
                            <i class="fa fa-star" data-rate="2"></i>
                            <i class="fa fa-star" data-rate="3"></i>
                            <i class="fa fa-star" data-rate="4"></i>
                            <i class="fa fa-star" data-rate="5"></i>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Submit",
                    preConfirm: () => {
                        if (selectedRating === 0) {
                            swal.showValidationMessage('Please choose rating!');
                        }

                        return selectedRating;
                    },
                    didOpen: () => {
                        const stars = swal.getHtmlContainer().querySelectorAll('.fa-star');

                        stars.forEach((star, index) => {
                            star.addEventListener('click', () => {
                                selectedRating = index + 1;

                                updateStars(stars, selectedRating);
                            });
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: route('rating.store'),
                            method: 'POST',
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"),
                            },
                            data: {
                                book_id: id,
                                rating: result.value
                            },
                            success: function(response) {
                                if (response.code === 201) {
                                    swal.fire("Thank you!", response.message,
                                        "success");

                                    table.ajax.reload();
                                } else if (response.code === 400) {
                                    swal.fire("Info", response.message, "info");
                                } else {
                                    swal.fire("Oops!", "Unexpected response!",
                                        "warning");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal.fire("Error!",
                                    "Something went wrong while submitting the rating.",
                                    "error");
                            },
                        });
                    }
                });

                function updateStars(stars, rating) {
                    stars.forEach((star, index) => {
                        if (index < rating) {
                            star.classList.add('text-warning');
                        } else {
                            star.classList.remove('text-warning');
                        }
                    });
                }
            });
        });
    </script>
@endpush
