import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CompanyCarbonFootprintComponent } from './company-carbon-footprint.component';

describe('CompanyCarbonFootprintComponent', () => {
  let component: CompanyCarbonFootprintComponent;
  let fixture: ComponentFixture<CompanyCarbonFootprintComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CompanyCarbonFootprintComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(CompanyCarbonFootprintComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
