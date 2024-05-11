import { ApplicationConfig } from '@angular/core';
import { provideRouter, withComponentInputBinding} from '@angular/router';

import { routes } from './app.routes';
import { provideAnimationsAsync } from '@angular/platform-browser/animations/async';

export const appConfig: ApplicationConfig = {
  providers: [provideRouter(routes,withComponentInputBinding()), provideAnimationsAsync()]
};
export const API_CONFIG = {
  api_url: "http://localhost/"
}