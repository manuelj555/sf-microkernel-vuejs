import Vue from 'vue'
import PostList from './components/PostList.vue';
import PostForm from './components/PostForm.vue';
import Modal from './components/Modal.vue';
import VueResource from 'vue-resource';

var baseApiUrl = 'http://localhost/symfony/pruebas/micro_kernel/public/index.php/api/posts';

Vue.use(VueResource)

var App = new Vue({
	el: '#posts-crud',

	http: {
		//root: baseApiUrl + '{/id}',
	},

	data () {
		return {
			posts: [],
			currentPage: 1,
			activePost: {}, 
			showForm: false,
		}
	},

	ready () {
		this.resource = this.$resource(baseApiUrl + '/{id}')

		this.getPosts()
	},

	methods: {
		closeModalForm () {
			this.showForm = false
		},

		openModalForm (post) {
			this.showForm = true

			if(post){
				this.activePost = Object.assign({}, post)
			}
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
			});
		},

		goToPage (pageNumber) {
			this.currentPage = pageNumber
			this.getPosts()
		}
	},

	components: {PostList, PostForm, Modal}
})

// new PostValidator().validate({});