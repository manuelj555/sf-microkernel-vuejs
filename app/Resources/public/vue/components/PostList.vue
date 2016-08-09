<template>
	<table class="table table-bordered">
        <thead> 
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Fecha Creación</th>
            <th>Fecha Edición</th>
            <th style="width: 120px">Acciones</th>
        </tr>
        </thead>

        <tbody>
            <tr v-for="item in posts">
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
                <td>{{ item.created }}</td>
                <td>{{ item.updated }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            Acciones
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#" @click.prevent="onClickEdit(item)">Editar</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td colspan="100">No hay posts creados</td>
            </tr> -->
        </tbody> 
    </table>

    <paginator :page="currentPage" :per-page="10", :count="24" :on-click="changePage"></paginator>
</template>

<script>
import Paginator from './Paginator.vue' 

export default {
	props: {
		posts: {
			required: true,
			type: [Array, Object],
		},
        onEdit: {
            required: true,
            type: Function,
        },
        onChangePage: {
            required: true,
            type: Function,
        },
        currentPage: {type: Number}
	},

    methods: {

        onClickEdit (post) {
            this.onEdit(post)
        },

        changePage (page) {
            console.debug('Cambiando a la página ', page)
            this.onChangePage(page)
        },

    },

    components: {Paginator}
}
</script>