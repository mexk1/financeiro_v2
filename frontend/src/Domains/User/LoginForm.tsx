import { FormEvent, useCallback, useEffect, useState } from "react"
import { useCookies } from "react-cookie"
import { useNavigate } from "react-router-dom"
import DefaultForm from "../../components/DefaultForm"
import DefaultInput from "../../components/DefaultInput"
import DefaultInputLabel from "../../components/DefaultInputLabel"
import DefaultLoader from "../../components/DefaultLoader"
import DefaultPasswordInput from "../../components/DefaultPasswordInput"
import COOKIES_KEYS from "../../constants/COOKIES_KEYS"
import PAGES from "../../constants/PAGES"
import useApi from "../../services/api/hooks/useApi"
import useIsUserLogged from "./hooks/useIsUserLogged"

const LoginForm = () => {

  const api = useApi()
  const isLogged = useIsUserLogged()
  const navigate = useNavigate()
  const setCookie = useCookies([ COOKIES_KEYS.access_token ] )[1]
  const [ loading, setLoading ] = useState( false )

  const handleSubmit = useCallback( async ( e:FormEvent<HTMLFormElement> )=> {
    e.preventDefault()
    e.currentTarget.checkValidity()
    const data = new FormData( e.currentTarget )
    setLoading( true  )
    await api.post( 'auth/login', data )
      .then( res => {
        setCookie( COOKIES_KEYS.access_token, res.data )
        setTimeout( () => {
          setLoading( false )
          navigate( PAGES.home.path )
        }, 300 )
      })
      .catch( console.log )
    setLoading( false )
  }, [ api, navigate, setCookie ] )

  useEffect( () => {
    if( !isLogged ) return 
    navigate( PAGES.home.path )
  }, [ navigate, isLogged ])

  return (
    <div className="flex flex-col w-full mx-8">
      <div className="w-full bg-white rounded-md">
        <DefaultForm onSubmit={ handleSubmit } loading={ loading } >
          <DefaultInputLabel label="Email">
            <DefaultInput name="email" required />
          </DefaultInputLabel>
          
          <DefaultInputLabel label="Senha">
            <DefaultPasswordInput name="password" required />
          </DefaultInputLabel>
        </DefaultForm >
      </div>
      <div className="mt-4">
        {
          loading && <DefaultLoader />
        }
      </div>
    </div>
  )

}

export default LoginForm