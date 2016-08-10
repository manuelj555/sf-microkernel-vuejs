import Vue from 'vue'
import PostList from './components/PostList.vue'
import PostForm from './components/PostForm.vue'
import Modal from './components/Modal.vue'
import VueResource from 'vue-resource'
import Paginator from './components/Paginator.vue' 

var baseApiUrl = 'http://localhost/symfony/pruebas/micro_kernel/public/index.php/api/posts'

Vue.use(VueResource)

var App = new Vue({
	el: '#posts-crud',
	
	data () {
		return {
			posts: [],
			currentPage: 1,
			totalPosts: 0,
			activePost: {}, 
			showForm: false,
			showDeleteModal: false,
			postToBeDeleted: null,
		}
	},

	ready () {
		this.resource = this.$resource(baseApiUrl + '/{id}')

		this.getPosts()
	},

	methods: {
		closeModalForm () {
			this.showForm = false 
			this.activePost = {}
		},

		openModalForm (post) {
			this.showForm = true

			if(post){
				this.activePost = Object.assign({}, post)
			}
		},

		showDeleteConfirm (post) {
			this.showDeleteModal = true
			this.postToBeDeleted = post
		},

		hideDeleteConfirm () {
			this.showDeleteModal = false
			this.postToBeDeleted = null
		},

		savePost () { 

			var post = this.activePost;
			this.activePost = {};
			var promise = null;

			if (post.id) {
				promise = this.resource.update({id: post.id}, post)
			}else{
				promise = this.resource.save({}, post)
			}

			promise.then(() => { this.getPosts(); })
		},

		getPosts() {
			this.resource.get({page: this.currentPage}).then((res) => {
				this.$set('posts', res.json());
				this.$set('totalPosts', Number(res.headers['X-Total-Count']));
			});
		},

		goToPage (pageNumber) {
			this.currentPage = pageNumber
			this.getPosts()
		},

		deletePost () {
			if (!this.postToBeDeleted){
				return;
			}

			this.resource.delete({id: this.postToBeDeleted.id}).then((res) => { 
				this.getPosts()
				this.hideDeleteConfirm()
			})
		}
	},

	events: {
		'post-list.click.edit' (post) {
			this.openModalForm(post)
		},

		'post-list.click.delete' (post) {
			this.showDeleteConfirm(post)
		},

		'post-form.submit' (post) {
			this.savePost()
		},

		'post-form.cancel' (post) {
			this.closeModalForm()
		}
	},

	components: {PostList, PostForm, Modal, Paginator}
})