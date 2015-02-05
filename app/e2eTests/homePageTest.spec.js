/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


describe('A&S home', function() {
  browser.get('http://www.asV2.loc/');
    
  it('should have a title', function() {
    expect(browser.getTitle()).toContain('Assault');
  });
  
  it('should contain a login form',function(){
      expect(element(by.id('txtLogin')).isPresent()).toBe(true);
      expect(element(by.id('txtPwd')).isPresent()).toBe(true);
  });
  
  it('should contain a signup button', function(){
      var btnSignUp = element(by.id('btnSignUp'));
      expect(btnSignUp.isPresent()).toBe(true);
      expect(btnSignUp.getText()).toBe('Enroll');
  });
});