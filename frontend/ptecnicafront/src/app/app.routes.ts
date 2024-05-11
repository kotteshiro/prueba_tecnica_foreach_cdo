import { Routes } from '@angular/router';
import { LandingComponent } from './landing/landing.component';
import { TravelListComponent } from './travel-list/travel-list.component';
import { TravelComponent } from './travel/travel.component';

export const routes: Routes = [
    { path: '', component: LandingComponent },
    { path: 'traslados', component: TravelListComponent },
    { path: 'nuevo-traslado', component: TravelComponent },
    { path: 'traslado/:id', component: TravelComponent },
];
