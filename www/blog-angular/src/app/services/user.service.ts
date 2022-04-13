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
        login(user:any, gettoken = null):Observable<any>{
            if(gettoken != null){
                user.gettoken = "true";
            }
            console.log(3)
            let json = JSON.stringify(user);
            let params = "json="+json;
   
            let headers = new HttpHeaders().set('Content-Type','application/x-www-form-urlencoded');
            return this._http.post(this.url+'login',params,{headers:headers});
        }

}