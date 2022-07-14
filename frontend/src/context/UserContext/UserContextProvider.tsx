import { AxiosRequestHeaders } from "axios"
import {  PropsWithChildren, useCallback, useEffect, useState } from "react"
import { useCookies } from "react-cookie"
import UserContext from "."
import COOKIES_KEYS from "../../constants/COOKIES_KEYS"
import useApi from "../../services/api/hooks/useApi"
import { User } from "../../types/User"

const UserContextProvider: React.FC<PropsWithChildren<any>> = ( { children } ) => {
  
  const api = useApi()
  const [ cookies, setCookie, removeCookie ] = useCookies( [ COOKIES_KEYS.access_token ] )
  const [ state, setState ] = useState<User>()
  const [ loading, setLoading ] = useState( true )

  const loadInitial = useCallback( async () => {
    const token = cookies[COOKIES_KEYS.access_token ]
    const headers:AxiosRequestHeaders = {
      'Authorization': `Bearer ${token}`
    }
    token && await api.get('me', { headers, withCredentials: true } )
      .then( res => {
        setState( {
          ...res.data,
          access_token: token
        } )
      })
      .catch( err => {
        if( err.repsonse.status === 401 )
          removeCookie( COOKIES_KEYS.access_token )
          
        console.log( err )
      } )

    setLoading( false )
  }, [ api, cookies, removeCookie] )

  useEffect( () => {
    if( loading ) return 
    
    if( state?.access_token )
      setCookie( COOKIES_KEYS.access_token, state.access_token )
    
    if( !state?.access_token )
      removeCookie( COOKIES_KEYS.access_token )
  }, [ state, removeCookie, setCookie, loading ] )

  useEffect( () => {
    loadInitial()
  }, [ loadInitial ] )

  return (
    <UserContext.Provider value={{
      state, 
      setState 
    }} >
      {
        !loading &&  children 
      }
    </UserContext.Provider>
  )
}

export default UserContextProvider