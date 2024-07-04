@extends('admin.layouts.app')

@section('content')
    <div x-data="adminMain()" class="container d-flex w-100 flex-column justify-content-center align-items-center">
        <div class="w-100">
            <style>
                .status-table td:nth-child(2) {
                    text-align: right;
                }
            </style>



            <script>
                function adminMain() {
                    return {
                        filterUser() {
                            /*axios.get( route ,
                                params {
                                    
                                }
                             )*/
                        }
                    }
                }
            </script>
            <table class="table table-dark status-table">
                <thead>
                    <tr class="text-white d-flex justify-content-center">
                        <th class="table-light text-dark flex-grow-1">
                            <h2>Status</h2>
                        </th>
                        <th class="bg-dark align-self-center">
                            <input type="text" name="filter" @keyup="filterUser()" />
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="row">Registers</td>
                        <td>{{ count($users) }}</td>
                    </tr>
                </tbody>
            </table>

            <table class="table">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                            Phone
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $user->id }}
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
