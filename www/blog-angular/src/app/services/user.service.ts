//imjectable
import { Injectable } from '@angular/core';
//importar https    
import { HttpClient, HttpHeaders } from '@angular/common/http';
//observable
import { Observable } from 'rxjs';
//importar user
import { User } from '../models/user';
//importar global
import { Global } from './global';

@Injectable()
export class UserService {

    public url:string;
    public identity:string|null=null;
    public token:string|null=null;
    

    constructor(
            public _http:HttpClient
        ){
            this.url=Global.url
        }

        test(){
            return "Hola mundo desde un servicio";
        }
        
        register(user:User):Observable<any>{
            let json = JSON.stringify(user);
            let params = "json="+json;
            let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded');
            return this._http.post(this.url+'register',params,{headers:headers});
        }
        //login the user
        login(user:any, gettoken:any = null):Observable<any>{
            
            user.gettoken = gettoken;
        
            let json = JSON.stringify(user);
            let params = "json="+json;
   
            let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded');
            return this._http.post(this.url+'login',params,{headers:headers});


        }

        //obtener identidad
        getIdentity(){
            // let identity = JSON.parse(localStorage.getItem('identity')||);
            let identity = localStorage.getItem('identity')

            if(identity && identity != 'undefined'){
                this.identity = JSON.parse(localStorage.getItem('identity') || '{}');
            }else{
                this.identity = null;
            }
            return this.identity;
        }
        //obtener token
        getToken(){
            let token = localStorage.getItem('token');
            if(token && token != 'undefined'){
                this.token = token;
            }else{
                this.token = null;
            }
            return this.token;
        }

}