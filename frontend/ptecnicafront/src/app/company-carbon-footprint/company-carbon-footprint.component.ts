import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Companyco2 } from '../companyco2';
@Component({
  selector: 'app-company-carbon-footprint',
  standalone: true,
  imports: [CommonModule, HttpClientModule],
  templateUrl: './company-carbon-footprint.component.html',
  styleUrl: './company-carbon-footprint.component.css'
})
export class CompanyCarbonFootprintComponent {
  ammount:Companyco2 = {total:0};
  client = inject(HttpClient);
  ngOnInit(): void {
    this.fetchData();
  }
  fetchData(){
    this.client.get("http://localhost/company-carbon-footprint").subscribe((data:any) => {
      console.log(data)
      this.ammount = data;
    }
  )
  }
  // getData = async function() {
  //   const response = await fetch("http://localhost/company-carbon-footprint");
  //   const carbonfootprint = await response.json();
  //   console.log(carbonfootprint);
  //   this.ammount = carbonfootprint.total;
  // }
}
