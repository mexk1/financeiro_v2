import { FormEvent, useCallback, useContext } from "react"
import DefaultForm from "../../components/DefaultForm"
import DefaultInput from "../../components/DefaultInput"
import DefaultInputLabel from "../../components/DefaultInputLabel"
import DefaultPasswordInput from "../../components/DefaultPasswordInput"
import UserContext from "../../context/UserContext"
import api from "../../services/api"

const LoginForm = () => {

  const { setState: setUser } = useContext( UserContext )

  const handleSubmit = useCallback( async ( e:FormEvent<HTMLFormElement> )=> {
    e.preventDefault()
    const data = new FormData( e.currentTarget )
    await api.post( 'auth/login', data )
      .then( res => {
        console.log( res )
      })
      .catch( console.log )
  }, [] )

  return (
    <DefaultForm onSubmit={ handleSubmit }  >
      <DefaultInputLabel label="Email">
        <DefaultInput name="email" />
      </DefaultInputLabel>
      
      <DefaultInputLabel label="Senha">
        <DefaultPasswordInput name="password" />
      </DefaultInputLabel>

    </DefaultForm >
  )

}

export default LoginForm