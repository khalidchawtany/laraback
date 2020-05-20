import { Model } from '@vuex-orm/core'
import User from './User'

export default class bread_model_class extends Model {
    static entity = 'bread_model_variables'

    static fields () {
        return {
            // id: this.increment(),
            id: this.attr(0),
            /* bread_js_model_fields */
            user_id: this.number(0),
            user: this.belongsTo(User, 'user_id'),
        }
    }
    static apiConfig = {
        baseURL: '/bread_model_variables',

        actions: {
            fetchById (id) {
                return this.get(`/get/${id}`);
            },

            destroy(id) {
                return this.delete(`/${id}`, { delete: id, });
            },

            update(id, data) {
                return this.put(`/${id}`, { ...data }, {dataKey: 'obj'});
            },

            fetch: {
                method: 'get',
                url: '/paginate',
            },

            post: {
                method: 'post',
                url: '',
            },

        }
    }

}
