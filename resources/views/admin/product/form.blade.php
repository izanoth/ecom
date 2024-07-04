@extends('admin.layouts.app')

@section('content')
    @if (isset($message))
        {{ $message }}
    @endif
    <style>
        body {
            background-color: rgb(150,150,150);
            color: white;
        }
    </style>
    <div class="w-10 bg-dark text-white d-flex justify-content-right align-items-right">
        <form class="align-self-right" method="POST" 
        action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="import_csv" class="d-block m-4">Importar CSV</label>
                <input type="file" name="import_csv" id="import_csv" class="d-block m-4" required>
            </div>
            <button type="submit" class="btn bg-white text-dark m-4">Importar</button>
        </form>
    </div>
    <div x-data="formHandler()" x-init="submitForm()" class="w-50">
        <form method="POST"
            action="{{ isset($id) ? route('admin.product.update', ['id' => $id]) : route('admin.product.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if (isset($id))
                @METHOD('PUT')
            @else
                @METHOD('POST')
            @endif

            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control" id="category_id" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>

                <div x-data="{ isOpen: false, newCategory: '' }">
                    <button class="btn btn-default bg-dark text-white my-2" type="button" x-on:click="isOpen = !isOpen">Add
                        New
                        Category</button>
                    <div x-show.transition="isOpen" class="mt-4 p-4 border rounded-lg shadow-lg bg-white">
                        <div class="mb-4">
                            <input type="text" id="new_category" name="new_category" class="form-control"
                                x-model="newCategory">
                        </div>
                        <a style="cursor:pointer" class="btn btn-default bg-secondary text-white newData-btn"
                            id="newCategory" x-bind:data-value="newCategory" x-on:click="submitData($event)" x-data="newCatOrBrand"
                            data-route="{{ route('admin.belongs.store') }}" data-option="category_id">Save</a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="brand_id">Brand:</label>
                <select class="form-control" id="brand_id" name="brand_id">
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                    @endforeach
                </select>

                <div x-data="{ isOpen: false, newBrand: '' }">
                    <button class="btn btn-default bg-dark text-white my-2" type="button" x-on:click="isOpen = !isOpen">Add
                        New
                        Brand</button>
                    <div x-show.transition="isOpen" class="mt-4 p-4 border rounded-lg shadow-lg bg-white">
                        <div class="mb-4">
                            <input type="text" id="new_brand" name="new_brand" class="form-control" x-model="newBrand">
                        </div>
                        <a style="cursor:pointer" class="btn btn-default bg-secondary text-white newData-btn" id="newBrand"
                            x-bind:data-value="newBrand" x-on:click="submitData($event)" x-data="newCatOrBrand"
                            data-route="{{ route('admin.belongs.store') }}" data-option="brand_id">Save</a>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ isset($product) ? $product->title : (isset($error) ? old('title') : '') }}" required>
            </div>

            @if (isset($product))
                <div class="form-group">
                    <label for="width">Specifications (valores de referencia. Esse campo é inativo):</label>
                    <textarea class="form-control" rows="10" disabled>{{ json_encode($product->specifications) }}</textarea>
                </div>
            @endif


            <script>
                function formHandler() {
        return {
            rows: [{
                key: 'Largura',
                value: '100',
                nestedRows: [],
                hideValueField: false
            }],

            addRow() {
                this.rows.push({
                    key: '',
                    value: '',
                    nestedRows: [],
                    hideValueField: false
                });
            },

            addNestedRow(rowIndex) {
                this.rows[rowIndex].nestedRows.push({
                    key: '',
                    value: ''
                });
                console.log(this.rows[rowIndex]);

            },

            removeRow(rowIndex) {
                this.rows[rowIndex].nestedRows = [];
                this.rows[rowIndex].hideValueField = false;
                //document.querySelector(`input[name='value_${rowIndex}']`).setAttribute('required');
            },

            hideValueField(rowIndex) {
                this.rows[rowIndex].hideValueField = true;
                //document.getElementById(`value_${rowIndex}`).removeAttribute('required');
            },

            renderRowTemplate(row, rowIndex) {
                return document.getElementById('row-template').innerHTML
                    .replace(/row\.key/g, `rows[${rowIndex}].key`)
                    .replace(/row\.value/g, `rows[${rowIndex}].value`)
                    .replace(/rowIndex/g, rowIndex)
                    .replace(/nestedRow\.key/g, `rows[${rowIndex}].nestedRows[$1].key`)
                    .replace(/nestedRow\.value/g, `rows[${rowIndex}].nestedRows[$1].value`)
                    .replace(/\$1/g, 'nestedIndex');
            },

            submitForm() {
                const specsData = Array.from(this.rows);
                var arr = []
                specsData.forEach(row => {
                    const nestedData = row.nestedRows.reduce((acc, nestedRow) => {
                        acc[nestedRow.key] = nestedRow.value ?? "";
                        return acc;
                    }, {});

                    const dataObject = {};
                    if (Object.keys(nestedData).length > 0) {
                        dataObject[row.key] = nestedData ?? "";
                    } else {
                        dataObject[row.key] = row.value ?? "";
                    }

                    arr.push(dataObject);
                });
                const jsonData = JSON.stringify(arr);
                let array = JSON.parse(jsonData);
                let result = {};
                array.forEach(item => {
                    Object.assign(result, item);
                });
                let restructuredJsonString = JSON.stringify(result, null, 2);
                document.getElementById('specifications').value = restructuredJsonString;
                console.log(restructuredJsonString);
            }
        }
    }
    </script>

            <input type="hidden" name="specifications" id="specifications" value="[{:}]" />
            <div class="form-group">
                <p>Specifications:</p>
                <div x-ref="specsInputs" x-data="formHandler()" class="space-y-4 w-50 d-flex flex-row">
                    <!-- Template para fileiras principais -->
                    <template id="row-template">
                        <div class="space-y-2 border p-2 rounded-md px-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Rótulo</label>
                                    <input @keyup="submitForm()" x-model="row.key" type="text" class="form-control"
                                        :name="'key_' + row.key" required>
                                </div>
                                <div x-show="!row.hideValueField">
                                    <label class="block text-sm font-medium text-gray-700">Info</label>
                                    <input @keyup="submitForm()" x-show="!row.hideValueField" x-model="row.value"
                                        type="text" class="form-control" :id="'value_' + row.value"
                                        :name="'value_' + row.value">
                                </div>
                            </div>
                            <!-- Subtemplate para fileiras aninhadas -->
                            <div>
                                <template x-for="(nestedRow, nestedIndex) in row.nestedRows" :key="nestedIndex">
                                    <div class="grid grid-cols-2 gap-4 form-group">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Rótulo</label>
                                            <input @keyup="submitForm()" x-model="nestedRow.key" type="text"
                                                class="form-control bg-secondary text-white"
                                                :name="'subkey_' + nestedRow.key" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Info</label>
                                            <input @keyup="submitForm()" x-model="nestedRow.value" type="text"
                                                class="form-control bg-secondary text-white"
                                                :name="'subvalue_' + nestedRow.value" required>
                                        </div>
                                </template>
                                <div class="text-right">
                                    <button type="button" class="btn btn-default bg-secondary  text-white my-2"
                                        @click="addNestedRow(rowIndex), hideValueField(rowIndex), submitForm()">Add
                                        subconjunto</button>
                                </div>
                            </div>
                            <div class="text-right" x-show="row.hideValueField">
                                <button type="button" class="btn btn-default bg-danger text-white"
                                    @click="removeRow(rowIndex), submitForm()">Remover
                                    subconjunto</button>
                            </div>
                        </div>
                    </template>

                    <!-- Renderização das fileiras principais -->
                    <template x-for="(row, rowIndex) in rows" :key="rowIndex">
                        <div x-data="{ row, rowIndex }" x-html="renderRowTemplate(row, rowIndex)"></div>
                    </template>

                    <!-- Botão para adicionar nova fileira -->
                    <div class="d-flex flex-column">
                        <div class="text-right my-2">
                            <button type="button" class="btn btn-default bg-dark  text-white mx-2"
                                @click="addRow, submitForm()">Add Conjunto</button>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-default bg-danger  text-white mx-2"
                                @click="removeRow(), submitForm()">Remover Conjunto</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="price">Price: *use pontos Ex.: 999.99</label>
                    <input type="text" class="form-control w-30" id="price" name="price"
                        value="{{ isset($product) ? $product->price : (isset($error) ? old('price') : '') }}" required>
                </div>

                <div class="form-group">
                    <label for="images">Images:</label>
                    <input type="file" accept="image/*" class="form-control-file" id="images" name="images[]"
                        multiple required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control-file" id="description" name="description">{{ isset($product) ? $product->description : (isset($error) ? old('title') : '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="images">Stoch:</label>
                    <input type="number" class="form-control w-30" id="in_stoch" name="in_stoch"
                        value="{{ isset($product) ? $product->in_stoch : (isset($error) ? old('title') : '') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Edit' : 'Create' }}</button>
        </form>
    </div>
@endsection
