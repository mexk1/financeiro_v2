import { useEffect } from "react"
import { useNavigate } from "react-router-dom"
import PAGES from "../../constants/PAGES"
import useIsUserLogged from "../../Domains/User/hooks/useIsUserLogged"
import LoginForm from "../../Domains/User/LoginForm"

const Login = () => {

  const navigate = useNavigate()

  const isLogged = useIsUserLogged()

  useEffect( () => {
    isLogged && navigate( PAGES.home.path )
  }, [ isLogged, navigate ] )

  return (
    <div className="h-screen w-screen flex items-center justify-center bg-gray-900">
      <LoginForm/>
    </div>
  )

}


export default Login