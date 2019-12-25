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

    static onResponse = {
        create: (data) => {
            return data.obj;
        },
        delete: (data) => {
            return data.obj;
        },
        fetch: (data) => {
            return data;
        },
        get: (data) => {
            return data;
        },
        update: (data) => {
            return data.obj;
        },
    };

    static methodConf = {
        http: {
            url: '/bread_model_variables'
        },
        methods: {
            $fetch: {
                name: 'fetch',
                http: {
                    url: '/paginate',
                    method: 'get',
                },
            },
            $get: {
                name: 'get',
                http: {
                    url: '/get/:id',
                    method: 'get',
                },
            },
            $create: {
                name: 'create',
                http: {
                    url: '',
                    method: 'post',
                },
            },
            $update: {
                name: 'update',
                http: {
                    url: '/:id',
                    method: 'put',
                },
            },
            $delete: {
                name: 'delete',
                http: {
                    url: '/:id',
                    method: 'delete',
                },
            },
        },
    }
}
