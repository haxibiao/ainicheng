
<template>
  <div>
    <multiselect
      v-model="multiValue"
      :options="options"
      :multiple="true"
  	  :placeholder="placeholder"
  	  label="name"
  	  track-by="id"	  
	  @input="updateSelected"
      >
    </multiselect>
    <input name="categories" type="hidden">
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";

export default {
	name: "CategorySelect",

	props: ["categories", "api", "placeholder"],

	computed: {
		apiUrl() {
			return this.api ? this.api : "/api/categories";
		}
	},

	components: { Multiselect },

	mounted() {
		console.log(this.categories);
		if (this.categories) {
			//加载选择的
			var data = JSON.parse(this.categories);
			this.multiValue = [];
			for (var i in data) {
				this.multiValue.push({
					id: i,
					name: data[i]
				});
			}
			$('input[name="categories"]').val(JSON.stringify(this.multiValue));
		}

		this.fetchData();
	},

	methods: {
		fetchData() {
			//加载可选择列表
			var _this = this;
			console.log(this.apiUrl);
			window.axios.get(this.apiUrl).then(function(response) {
				_this.options = response.data;
			});
		},
		updateSelected(val) {
			$('input[name="categories"]').val(JSON.stringify(this.multiValue));
		}
	},

	data() {
		return {
			multiValue: null,
			options: [1, 2, 3, 4, 5, 6, 7, 8, 9]
		};
	}
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css">
</style>
<style lang="scss">
.multiselect--active {
	z-index: 2;
}
.multiselect__tag {
	background-color: #fff;
	border: 1px solid #42c02e;
	color: #42c02e;
	.multiselect__tag-icon {
		&:hover {
			background-color: #42c02e;
		}
	}
}
.multiselect__option--highlight {
	background-color: rgba(#42c02e, 0.5);
	&:after {
		background-color: rgba(#42c02e, 0.5);
	}
}
.multiselect__option--selected.multiselect__option--highlight {
	background-color: #ff9999;
	&:after {
		background-color: #ff9999;
	}
}
</style>
