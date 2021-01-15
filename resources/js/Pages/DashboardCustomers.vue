<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <button @click="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Criar novo cliente</button>
                    <table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20">Id</th>
                                <th class="px-4 py-2">Usuário</th>
                                <th class="px-4 py-2">Nome</th>
                                <th class="px-4 py-2">Documento</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in data">
                                <td class="border px-4 py-2">{{ row.id }}</td>
                                <td class="border px-4 py-2">(#{{row.user_id}}){{ getUserName(row.user_id) }}</td>
                                <td class="border px-4 py-2">{{ row.name }}</td>
                                <td class="border px-4 py-2">{{ row.document }}</td>
                                <td class="border px-4 py-2">{{ getStatus(row.status) }}</td>

                                <td class="border px-4 py-2">
                                    <button @click="edit(row)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                                    <button @click="deleteRow(row)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Deletar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        
                        <div class="fixed inset-0 transition-opacity">
                          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                        </div>
                        
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                          <form>
                          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="">
                                    <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">User Id:</label>
                                      <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" v-model="form.user_id" >
                                          <option v-for="user in users" :value="user.id">(#{{user.id}}){{user.name}}</option>
                                      </select>
                                  </div>
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
                                      <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Digite o nome" v-model="form.name">
                                  </div>
                                  <div class="mb-4">
                                      <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Documento:</label>
                                      <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" v-model="form.document" placeholder="Digite o documento"></textarea>
                                  </div>
                                  <div class="mb-4" v-show="editMode" >
                                      <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                                      <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput2" v-model="form.status" >
                                          <option value="new">Novo</option>
                                          <option value="active">Ativo</option>
                                          <option value="suspended">Suspenso</option>
                                          <option value="cancelled">Cancelado</option>
                                      </select>
                                  </div>
                            </div>
                          </div>
                          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="!editMode" @click="save(form)">
                                Salvar
                              </button>
                            </span>
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                              <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" v-show="editMode" @click="update(form)">
                                Editar
                              </button>
                            </span>
                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                              
                              <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancelar
                              </button>
                            </span>
                          </div>
                          </form>
                          
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
    import AppLayout from './../Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },

        props: ['data', 'users', 'errors'],

        data() {
            return {
                editMode: false,
                isOpen: false,
                form: {
                    user_id : null,
                    name    : null,
                    document: null,
                    status  : null,
                },
            }
        },

        beforeCreate() {},
        created() {},

        beforeMount() {},
        mounted() {},

        beforeUpdate() {},
        updated() {},

        beforeDestroy() {},
        destroyed() {},

        methods: {
            getUserName(id_user){
                for (var prop in this.users) {
                    if ( this.users.hasOwnProperty(prop) ) 
                        if(this.users[prop].id == id_user)
                            return this.users[prop].name;
                }
            },
            getStatus(status){
                if(status == 'new')
                    return 'Novo';
                else if(status == 'active')
                    return 'Ativo';
                else if(status == 'suspended')
                    return 'Suspenso';
                else if(status == 'cancelled')
                    return 'Cancelado';
            },
            openModal: function () {
                this.isOpen = true;
            },
            closeModal: function () {
                this.isOpen = false;
                this.reset();
                this.editMode=false;
            },
            reset: function () {
                this.form = {
                    user_id : null,
                    name: null,
                    document: null,
                    status: null,
                }
            },
            save: function (data) {
                this.form.status = 'new';
                this.$inertia.post('/customers/post', data)
                this.reset();
                this.closeModal();
                this.editMode = false;
            },
            edit: function (data) {
                this.form = Object.assign({}, data);
                this.editMode = true;
                this.openModal();
            },
            update: function (data) {
                data._method = 'PUT';
                this.$inertia.post('/customers/update/' + data.id, data)
                this.reset();
                this.closeModal();
            },
            deleteRow: function (data) {
                if (!confirm('Tem certeza que deseja deletar?')) return;
                data._method = 'DELETE';
                this.$inertia.post('/customers/delete/' + data.id, data)
                this.reset();
                this.closeModal();
            }
        }
    }
</script>