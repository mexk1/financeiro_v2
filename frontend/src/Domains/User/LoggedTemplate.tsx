import { PropsWithChildren, useEffect } from "react"
import { useNavigate } from "react-router-dom"
import PAGES from "../../constants/PAGES"
import useIsUserLogged from "./hooks/useIsUserLogged"

const LoggedTemplate = ( { children, title = "Financeiro" }:Props ) => {

  const navigate = useNavigate()
  const isLogged = useIsUserLogged()
  
  useEffect( () => {
    !isLogged && PAGES.login.path && navigate( PAGES.login.path )
  }, [ navigate ] )

  return !isLogged ? null : ( 
    <div className="w-screen h-full flex flex-col">
      <div className="w-full h-12 flex items-center justify-center shadow-md bg-purple-700">
        <span className="font-bold text-white">
          { title }
        </span>
      </div>
      <div className="flex-1 bg-gray-900 text-white flex items-center justify-center">
        {  children}
      </div>
      <div className="w-full h-24 relative">
        <div className="z-10 absolute translate-x-2/4	right-1/2 -top-8 h-16 w-16 rounded-full bg-purple-500 shadow-md">
        </div>
        <div className="px-8 h-full flex items-center justify-between bg-purple-700">
          {
            ['1', '2', '3', '4'].map( menu_item =>(
              <div key={ menu_item } className="bg-white shadow-md w-12 h-12 flex items-center justify-center rounded-md">
                { menu_item }
              </div>
            ))
          }
        </div>
      </div>
    </div>
  )
}
interface Props extends PropsWithChildren<any> {
  title?: string
}
export default LoggedTemplate