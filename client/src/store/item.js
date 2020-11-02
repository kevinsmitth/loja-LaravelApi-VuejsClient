import axios from 'axios'

export default{
    
    show:() => {axios.get(`/products/${this.id}`
                        
        )
        .then(response => {
            console.log(response)
        })
    }

}