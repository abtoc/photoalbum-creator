import Uppy from "@uppy/core";
import XHRUpload from "@uppy/xhr-upload";
import Dashboard from "@uppy/dashboard";
import GoogleDrive from "@uppy/google-drive";
import ja_JP from '@uppy/locales/lib/ja_JP';
import axios from "axios";

if(document.getElementById("uppy-select-files") != null){
    axios.get('/api-token')
    .then(function(response){
        const uppy = new Uppy({
                debug: true,
                restrictions: {
                    maxFileSize: 20000000, //20MB
                    maxNumberOfFiles: 20,
//                    allowedFileTypes: ['image/*'],
                },
            })
            .use(Dashboard, {
                target: '#uppy-drop-area',
                trigger: '#uppy-select-files',
                locale: ja_JP,
            })
            .use(GoogleDrive, {
                target: Dashboard,
                companionUrl: 'http://localhost:3020/',
            })
            .use(XHRUpload, {
                endpoint: 'http://localhost/api/photos/upload?api_token=' + response.data.api_token,
                headers: {
                    //'X-CSRF-TOKEN': document.querySelector('[name=csrf-token]').content,
                    'Authorization': 'Bearer ' + response.data.api_token,
                },
            });
        uppy.on('complete', (result) => {
                Livewire.emit('refreshComponent')
            })
    })
    .catch(function(error){
        console.log(error)
    })
    .finally(function(){
        console.log('finally')
    })
}
