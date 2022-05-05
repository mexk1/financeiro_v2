import { useCallback, useContext, useEffect, useState } from "react"
import { useNavigate } from "react-router-dom"
import DefaultLoader from "../../components/DefaultLoader"
import PAGES from "../../constants/PAGES"
import UserContext from "../../context/UserContext"
import useIsUserLogged from "../../Domains/User/hooks/useIsUserLogged"
import LoggedTemplate from "../../Domains/User/LoggedTemplate"
import useApi from "../../services/api/hooks/useApi"

const Logout = () => {

  const navigate = useNavigate()
  
  const { setState: setUser } = useContext( UserContext )

  const api = useApi()
  const [ loading, setLoading ] = useState( false )
  const isLogged = useIsUserLogged()

  const doLogout = useCallback( async () => {
    setLoading( true )
    await api.get('auth/logout')
      .then( () => setUser( undefined ) )
      .catch( console.log )
    setLoading( false )
  }, [ api, setUser ] )

  useEffect( () => {
    !isLogged && navigate( PAGES.login.path )
  }, [ isLogged, navigate ] )

  useEffect( () => {
    isLogged && doLogout()
  }, [ doLogout, isLogged ])

  return (
    <LoggedTemplate >
      <div className="flex-1 items-center justify-center">
        { loading && <DefaultLoader /> }
      </div>
    </LoggedTemplate>
  )

}


export default Logout