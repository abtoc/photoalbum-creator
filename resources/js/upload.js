import Uppy from "@uppy/core";
import XHRUpload from "@uppy/xhr-upload";
import Dashboard from "@uppy/dashboard";
import GoogleDrive from "@uppy/google-drive";
import ja_JP from '@uppy/locales/lib/ja_JP';
import axios from "axios";
import { selectCategoryNew } from "./category_select";

if(document.getElementById("uppy-select-files") != null){
    axios.get('/api-token')
    .then(function(response){
        let uploaded = false;
        const uppy = new Uppy({
                debug: true,
                restrictions: {
                    maxFileSize: response.data.max_file_size,
                    maxNumberOfFiles: response.data.count,
                    allowedFileTypes: ['image/*'],
                },
            })
            .use(Dashboard, {
                target: '#uppy-drop-area',
                trigger: '#uppy-select-files',
                locale: ja_JP,
            })
            .use(GoogleDrive, {
                target: Dashboard,
                companionUrl: response.data.companion_url,
            })
            .use(XHRUpload, {
                endpoint: response.data.endpoint,
                headers: {
                    //'X-CSRF-TOKEN': document.querySelector('[name=csrf-token]').content,
                    'Authorization': 'Bearer ' + response.data.api_token,
                },
                limit: response.data.limit,
                timeout: response.data.timeout,
                getResponseError: (responseText, response) => {
                    return new Error(JSON.parse(responseText).message);
                },
            });
        uppy.on('complete', (result) => {
            console.log('complete');
            uploaded = true;
            Livewire.emit('refreshComponent')
        });
        uppy.on('dashboard:modal-closed', () => {
            if(uploaded) selectCategoryNew(response.data.upload_id);
            uploaded = false;
            console.log('modal-closed');
        });
        uppy.on('upload-error', (file, error, response) => {
            console.log('upload-error');
            console.log(response);
        });
        uppy.on('error', (error) => {
            console.log('error');
        });
    })
    .catch(function(error){
        console.log(error)
    })
    .finally(function(){
        console.log('finally')
    })
}
