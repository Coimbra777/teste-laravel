<template>
    <div class="container">
        <div class="agenda-container">
            <div v-if="!showForm && !showEditForm">
                <h2 class="title">Lista de Contatos</h2>
                <!-- Tabela de contatos -->
                <table class="agenda-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="contact in contacts" :key="contact.id">
                            <td>{{ contact.id }}</td>
                            <td>{{ contact.name }}</td>
                            <td>{{ contact.email }}</td>
                            <td>{{ contact.phone }}</td>
                            <td>
                                <button
                                    class="edit-btn"
                                    @click="editContact(contact)"
                                >
                                    Editar
                                </button>
                                <button
                                    class="delete-btn"
                                    @click="deleteContact(contact.id)"
                                >
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Botão para mostrar ou ocultar o formulário -->
                <button class="create-btn" type="button" @click="toggleForm">
                    Novo Contato
                </button>
            </div>

            <!-- Formulário para criar um novo contato -->
            <div v-if="showForm">
                <h2 class="title">Novo Contato</h2>
                <form @submit.prevent="createContact" class="create-form">
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input
                            type="text"
                            id="name"
                            v-model="newContact.name"
                            required
                            class="input-field"
                        />
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input
                            type="email"
                            id="email"
                            v-model="newContact.email"
                            required
                            class="input-field"
                        />
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefone:</label>
                        <input
                            type="text"
                            id="phone"
                            v-model="newContact.phone"
                            placeholder="(99)9 9999-9999"
                            required
                            class="input-field"
                        />
                    </div>
                    <div class="form-actions">
                        <button class="create-btn">Salvar</button>
                        <button
                            class="create-btn cancel-btn"
                            @click="cancelCreate"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Formulário para editar um contato -->
            <div v-if="showEditForm">
                <h2 class="title">Editar Contato</h2>
                <form @submit.prevent="updateContact" class="form">
                    <div class="form-group">
                        <label for="editName">Nome:</label>
                        <input
                            type="text"
                            id="editName"
                            v-model="editedContact.name"
                            required
                            class="input-field"
                        />
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email:</label>
                        <input
                            type="email"
                            id="editEmail"
                            v-model="editedContact.email"
                            required
                            class="input-field"
                        />
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Telefone:</label>
                        <input
                            type="text"
                            id="editPhone"
                            v-model="editedContact.phone"
                            placeholder="(99)9 9999-9999"
                            required
                            class="input-field"
                        />
                    </div>
                    <div class="form-actions">
                        <button class="update-btn">Atualizar</button>
                        <button class="cancel-btn" @click="cancelEdit">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            contacts: [],
            newContact: {
                name: "",
                email: "",
                phone: "",
            },
            editedContact: {
                id: null,
                name: "",
                email: "",
                phone: "",
            },
            showForm: false,
            showEditForm: false,
        };
    },

    mounted() {
        this.loadContacts();
    },
    methods: {
        toggleForm() {
            this.showForm = !this.showForm;
            this.showEditForm = false;
        },
        loadContacts() {
            axios
                .get("http://localhost:8989/api/contacts/")
                .then((response) => {
                    this.contacts = response.data.data;
                })
                .catch((error) => {
                    console.error("Erro ao carregar contatos:", error);
                });
        },
        // metodo para criar contato
        createContact() {
            axios
                .post("http://localhost:8989/api/contacts", this.newContact)
                .then((response) => {
                    this.contacts.push(response.data);
                    this.newContact = { name: "", email: "", phone: "" };
                    this.showForm = false;
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error("Erro ao criar contato:", error);
                    }
                });
        },
        cancelCreate() {
            this.showForm = false;
            this.newContact = { name: "", email: "", phone: "" };
        },
        // metodo para editar contato
        editContact(contact) {
            this.editedContact.id = contact.id;
            this.editedContact.name = contact.name;
            this.editedContact.email = contact.email;
            this.editedContact.phone = contact.phone;
            this.showEditForm = true;
            this.showForm = false;
        },
        cancelEdit() {
            this.showEditForm = false;
            this.editedContact = { id: null, name: "", email: "", phone: "" };
        },
        updateContact() {
            axios
                .put(
                    `http://localhost:8989/api/contacts/${this.editedContact.id}`,
                    this.editedContact
                )
                .then(() => {
                    alert("Usuário editado com sucesso!");
                    this.loadContacts();
                    this.showEditForm = false;
                    this.editedContact = {
                        id: null,
                        name: "",
                        email: "",
                        phone: "",
                    };
                })
                .catch((error) => {
                    console.error("Erro ao atualizar contato:", error);
                });
        },
        // metodo para excluir contato
        deleteContact(contactId) {
            if (confirm("Tem certeza de que deseja excluir este contato?")) {
                axios
                    .delete(`http://localhost:8989/api/contacts/${contactId}`)
                    .then(() => {
                        this.contacts = this.contacts.filter(
                            (contact) => contact.id !== contactId
                        );
                    })
                    .catch((error) => {
                        console.error("Erro ao excluir contato:", error);
                    });
            }
        },
    },
};
</script>

<style scoped>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.agenda-container {
    width: 100%;
    max-width: 1000px;
    padding: 20px;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.title {
    text-align: center;
}

.agenda-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.agenda-table th,
.agenda-table td {
    padding: 8px;
    border: 1px solid #ddd;
}

.agenda-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.agenda-table td {
    text-align: center;
}

.view-btn,
.edit-btn,
.delete-btn,
.create-btn {
    padding: 8px 12px;
    margin-right: 5px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: #fff;
    font-size: 14px;
    transition: background-color 0.3s;
}

.view-btn:hover,
.edit-btn:hover,
.delete-btn:hover,
.create-btn:hover {
    background-color: #0056b3;
}

.create-btn {
    background-color: #28a745;
}

.update-btn {
    padding: 8px 12px;
    margin-right: 5px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    color: #000;
    font-size: 14px;
    transition: background-color 0.3s;
    background-color: #ffc107;
}

.cancel-btn {
    padding: 8px 12px;
    margin-right: 5px;
    cursor: pointer;
    border: none;
    border-radius: 4px;
    font-size: 14px;
    transition: background-color 0.3s;
    background-color: #dc3545;
}
.cancel-btn:hover {
    background-color: #dc3545;
}

.create-btn:hover,
.update-btn:hover,
.cancel-btn:hover {
    opacity: 0.9;
    transition: opacity 0.3s;
}

.edit-form {
    margin-top: 20px;
}

.title {
    font-size: 1.5em;
    margin-bottom: 15px;
}

.form {
    width: 100%;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.input-field {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-actions {
    display: flex;
    justify-content: space-between;
}

.update-btn,
.cancel-btn {
    padding: 8px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.update-btn {
    background-color: #007bff;
    color: #fff;
}

.cancel-btn {
    background-color: #dc3545;
    color: #fff;
}

.update-btn:hover,
.cancel-btn:hover {
    opacity: 0.9;
}
</style>
