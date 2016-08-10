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
                            <li><a href="#" @click.prevent="onClickDelete(item)">Eliminar</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td colspan="100">No hay posts creados</td>
            </tr> -->
        </tbody> 
    </table>
</template>

<script>

export default {
	props: {
		posts: {
			required: true,
			type: [Array, Object],
		},
	},

    methods: {
        onClickEdit (post) {
            this.$dispatch('post-list.click.edit', post)
        },

        onClickDelete (post) {
            this.$dispatch('post-list.click.delete', post)
        }
    },
}
</script>