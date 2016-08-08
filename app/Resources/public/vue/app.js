import PostList from './components/PostList.vue';
import PostForm from './components/PostForm.vue';
import Modal from './components/Modal.vue';
import PostValidator from './post.validation.js';

var baseApiUrl = 'http://localhost/symfony/pruebas/micro_kernel/public/index.php/api/posts';

//var validator = new PostValidator();

var App = new Vue({
	el: '#posts-crud',

	http: {
		//root: baseApiUrl + '{/id}',
	},

	data () {
		return {
			posts: [],
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
			//this.showForm = false
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
			this.resource.get().then((res) => {
				this.$set('posts', res.json());
			});
		}
	},

	components: {PostList, PostForm, Modal}
})

// new PostValidator().validate({});