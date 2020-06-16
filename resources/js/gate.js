export default class gate{

    // construct
    constructor(user){
        this.user = user;
    }

    isAdmin() {
       return this.user.type === 'admin';
    }

     isUser() {
        return this.user.type === 'user';
     }
     isAdminOrisAuthor(){
         if(this.user.type === 'admin' || this.user.type === 'author'){
             return true;
         }
     }
}
