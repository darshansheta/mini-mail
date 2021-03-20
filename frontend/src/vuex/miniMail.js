
import axios from 'axios';
import qs from 'qs';
import _ from 'lodash';

let mutations = {
    mailListDataMutation : (state,{data}) => {
        state.data = data;
    },
    filtersMutation:(state,{queue,filters,page,sort}) => {
        let changed = [];
        if (page) {
            changed.push('page')
            state.page = page;    
        }
        if (sort) {
            changed.push('sort')
            state.sort = sort;    
        }
        if (filters) {
            changed.push('filters')
            state.filters = filters
        }
    },
    statusMutation:(state,status) => {
        state.status = status
    },
    miniMailMutation:(state,miniMail) => {
        state.miniMail = miniMail;
    },
    recipientsMutation:(state,recipients) => {
        state.recipients = recipients;
    },
    recipientMailsMutation:(state,recipientMails) => {
        state.recipientMails = recipientMails;
    }
}



let actions = {

    filterListAction({commit, dispatch,state}, param) {
        if (typeof this._source != typeof undefined) {
            this._source.cancel('Operation cancelled due to new request.')
        }

        this._source = axios.CancelToken.source();
        
        return new Promise((resolve, reject) => {
            param['filters'] = state.filters 
            param['sort'] = state.sort 
            param['page'] = state.page 
            axios({
                url: '/mini-mails',
                method: 'GET',
                params: param,
                cancelToken: this._source.token,
                paramsSerializer: function(params) {
                    return qs.stringify(params, {arrayFormat: 'brackets'});
                }
            })
            .then(resp => {
                if (resp){
                        commit('mailListDataMutation', {data:resp.data})
                }
                resolve(resp)

            }).catch(err => {
                if(axios.isCancel(err)) {

                } else {
                    reject(err)
                }
            })
        })
    },
    getMiniMailAction({commit, dispatch,state}, param) {
        
        
        return new Promise((resolve, reject) => {
            
            axios({
                url: '/mini-mails/'+param.id,
                method: 'GET',
            })
            .then(resp => {
                if (resp){
                        commit('miniMailMutation', resp.data.data)
                }
                resolve(resp)

            }).catch(err => {
                    reject(err)
            })
        })
    },
    getRecipientsAction({commit, dispatch,state}, param) {
        
        
        return new Promise((resolve, reject) => {
            
            axios({
                url: '/recipients',
                method: 'GET',
            })
            .then(resp => {
                if (resp){
                        commit('recipientsMutation', resp.data)
                }
                resolve(resp)

            }).catch(err => {
                    reject(err)
            })
        })
    },
    getRecipientMailsAction({commit, dispatch,state}, param) {
        
        
        return new Promise((resolve, reject) => {
            
            axios({
                url: '/recipients/'+param,
                method: 'GET',
            })
            .then(resp => {
                if (resp){
                        commit('recipientMailsMutation', resp.data.data)
                }
                resolve(resp)

            }).catch(err => {
                    reject(err)
            })
        })
    },

    submitMailAction({commit, dispatch,state}, param) {
        return new Promise((resolve, reject) => { 
            axios({
                url: '/mini-mails',
                method: 'POST',
                data: param,
                // paramsSerializer: function(params) {
                //     return qs.stringify(params, {arrayFormat: 'brackets'});
                // },
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(resp => {
                resolve(resp)
            }).catch(err => {
                reject(err)
            })
        })
    },
}
export default {
    namespaced: true,
    state: {
        data:{},
        page:1,
        filters:{},
        sort:{},
        status:'',
        miniMail: null,
        recipients:[],
        recipientMails:[]
    },
    getters: {
        dataGetter : state => state.data,
        statusGetter : state => state.status,
        miniMailGetter : state => state.miniMail,
        recipientsGetter : state => state.recipients,
        recipientMailsGetter : state => state.recipientMails
    },
    actions,
    mutations
}