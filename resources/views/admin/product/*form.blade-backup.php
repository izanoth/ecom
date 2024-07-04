@extends('admin.layouts.app')

@section('content')
    @if (isset($message))
        {{ $message }}
    @endif
    <div x-data="formHandler()" x-init="submitForm()">
        <form x-ref="form" x-on:submit.prevent="submitForm(true)" method="POST"
            action="{{ isset($product) ? route('admin.product.update', ['id' => $product->id]) : route('admin.product.store') }}"
            enctype="multipart/form-data">
            @csrf
            @isset($product)
                @method('PUT')
            @else
                @method('POST')
            @endisset
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('newData', () => ({
                        submitData(event) {
                            let element = event.target;
                            var value = element.getAttribute('data-value');
                            var route = element.getAttribute('data-route');
                            var select = document.getElementById(element.getAttribute(
                                'data-option'));
                            axios.get(route, {
                                    params: {
                                        title: value
                                    }
                                })
                                .then(response => {
                                    var new_id = response.data.id;
                                    var new_title = response.data.title;
                                    var new_option = document.createElement(
                                        'option');
                                    new_option.setAttribute('value', new_id);
                                    var textNode = document.createTextNode(
                                        new_title);
                                    new_option.appendChild(textNode);
                                    select.appendChild(new_option);
                                })
                                .catch(function(error) {
                                    console.error('Detalhes do erro:', error
                                        .message);
                                })
                        },
                    }))
                })
            </script>

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
                        <a style="cursor:pointer" class="btn btn-default bg-secondary  text-white" x-data="newData"
                            id="test" x-bind:data-value="newCategory" x-on:click="submitData($event)"
                            data-route="{{ route('admin.category.store') }}" data-option="category_id">Save</a>
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
                        <a style="cursor:pointer" class="btn btn-default bg-secondary  text-white" x-data="newData"
                            x-bind:data-value="newBrand" x-on:click="submitData($event)"
                            data-route="{{ route('admin.brand.store') }}" data-option="brand_id">Save</a>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title"
                    value="{{ isset($product) ? $product->title : (isset($error) ? old('title') : '') }}">
            </div>

            @if (isset($product))
                <div class="form-group">
                    <label for="width">Specifications (valores de referencia. Esse campo é inativo):</label>
                    <textarea class="form-control" rows="10" disabled>{{ json_encode($product->specifications) }}</textarea>
                </div>
            @endif


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
                                    <input @keyup="submitForm(false)" x-model="row.key" type="text" class="form-control">
                                </div>
                                <div x-show="!row.hideValueField">
                                    <label class="block text-sm font-medium text-gray-700">Info</label>
                                    <input @keyup="submitForm(false)" x-model="row.value" type="text"
                                        class="form-control">
                                </div>
                            </div>
                            <!-- Subtemplate para fileiras aninhadas -->
                            <div>
                                <template x-for="(nestedRow, nestedIndex) in row.nestedRows" :key="nestedIndex">
                                    <div class="grid grid-cols-2 gap-4 form-group">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Rótulo</label>
                                            <input @keyup="submitForm(false)" x-model="nestedRow.key" type="text"
                                                class="form-control">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Info</label>
                                            <input @keyup="submitForm(false)" x-model="nestedRow.value" type="text"
                                                class="form-control">
                                        </div>
                                    </div>
                                </template>
                                <div class="text-right">
                                    <button type="button" class="btn btn-default bg-secondary  text-white my-2"
                                        @click="addNestedRow(rowIndex), hideValueField(rowIndex), submitForm(false)">Add
                                        subconjunto</button>
                                </div>
                            </div>
                            <div class="text-right" x-show="row.hideValueField">
                                <button type="button" class="btn btn-default bg-danger  text-white"
                                    @click="removeRow(rowIndex), submitForm(false)">Remover
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
                                @click="addRow, submitForm(false)">Add Conjunto</button>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-default bg-danger  text-white mx-2"
                                @click="removeRow(), submitForm(false)">Remover Conjunto</button>
                        </div>
                    </div>

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
                                },

                                removeRow(rowIndex) {
                                    this.rows[rowIndex].nestedRows = [];
                                    this.rows[rowIndex].hideValueField = false;
                                },

                                hideValueField(rowIndex) {
                                    this.rows[rowIndex].hideValueField = true;
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

                                submitForm(bySubmit) {

                                    if (bySubmit) {
                                        const specsValue = document.getElementById('specifications').value;
                                        const json_parse = JSON.parse(specsValue);
                                        const inArray = Object.keys(json_parse).map(key => {
                                            if (typeof json_parse[key] === 'object' && json_parse[key] !== null) {
                                                return Object.keys(json_parse[key]).map(nestedKey => ({
                                                    [nestedKey]: json_parse[key][nestedKey]
                                                }));
                                            } else {
                                                return {
                                                    [key]: json_parse[key]
                                                };
                                            }
                                        });
                                        //const flattenedArr = arr.flat();
                                        //console.log(flattenedArr);



                                        const form = this.$refs.form;

                                        function hasNullOrUndefined(data) {
                                            function checkValues(obj) {
                                                for (const key in obj) {
                                                    console.log(key);
                                                    console.log(obj[key]);

                                                    if (obj[key] === null || obj[key] === undefined || obj[key] == "" || key === null || key === undefined || key == "") {
                                                        return true;
                                                    }
                                                    if (typeof obj[key] === 'object' && obj[key] !== null) {
                                                        if (checkValues(obj[key])) {
                                                            return true;
                                                        }
                                                    }
                                                }
                                                return false;
                                            }
                                            for (const row of data) {
                                                console.log(row);
                                                if (checkValues(row)) {
                                                    return true;
                                                }
                                            }
                                            return false;
                                        }
                                        hasNullOrUndefined(inArray) ?
                                            window.alert('Dados nulos em specs') :
                                            console.log('ok');

                                    } else {
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
                        }
                    </script>
                </div>

                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" class="form-control" id="price" name="price"
                        value="{{ isset($product) ? $product->price : (isset($error) ? old('price') : '') }}">
                </div>

                <div class="form-group">
                    <label for="images">Images:</label>
                    <input type="file" accept="image/*" class="form-control-file" id="images" name="images[]"
                        multiple>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control-file" id="description" name="description">{{ isset($product) ? $product->description : (isset($error) ? old('title') : '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="images">Stoch:</label>
                    <input type="number" class="form-control" id="in_stoch" name="in_stoch"
                        value="{{ isset($product) ? $product->in_stoch : (isset($error) ? old('title') : '') }}">
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Edit' : 'Create' }}</button>
        </form>
    @endsection
