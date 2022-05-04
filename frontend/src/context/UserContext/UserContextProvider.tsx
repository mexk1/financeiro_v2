import { PropsWithChildren, useState } from "react"
import { useCookies } from "react-cookie"
import UserContext from "."
import COOKIES_KEYS from "../../constants/COOKIES_KEYS"
import { User } from "../../types/User"

const UserContextProvider: React.FC<PropsWithChildren<any>> = ( { children } ) => {

  
  const [ cookies, setCookie, removeCookie ] = useCookies( [ COOKIES_KEYS.user_token ] )
  const [ state, setState ] = useState<User>()
  const [ loading, setLoading ] = useState( true )

  // useEffect( () => {
  //   const token = cookies[ COOKIES_KEYS.user_token ]
  //   if( !token ) {
  //     setState( undefined )
  //   }
  // }, [ cookies ] )

  return (
    <UserContext.Provider value={{
      state, 
      setState 
    }} >
      { children }
    </UserContext.Provider>
  )
}

export default UserContextProvider