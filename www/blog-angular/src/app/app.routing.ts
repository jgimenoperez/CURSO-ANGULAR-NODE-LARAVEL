import {ModuleWithProviders} from '@angular/core'
//importar clases y librerias del router 
import {RouterModule, Routes} from '@angular/router'
//imporarComponentess
import { LoginComponent } from './components/login/login.component'
import { RegisterComponent } from './components/register/register.component'
import { HomeComponent } from './components/home/home.component'
import { ErrorComponent } from './components/error/error.component'

//definir Rutas
const appRoutes: Routes = [
    {path: '', component: HomeComponent},
    {path: 'login', component: HomeComponent},
    {path: 'inicio', component: LoginComponent},
    {path: 'registro', component: RegisterComponent},
    {path: '**', component: ErrorComponent},

]

//exportar
export const appRoutingProviders: any[] = []
export const routing: ModuleWithProviders<RouterModule> = RouterModule.forRoot(appRoutes)



