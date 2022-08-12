import { PropsWithChildren, useEffect, useMemo } from "react"
import { useNavigate } from "react-router-dom"
import PAGES from "../../constants/PAGES"
import useIsUserLogged from "./hooks/useIsUserLogged"
import { FaHome, FaWallet } from 'react-icons/fa'
import { uniqueId } from "lodash"
import { BsGraphUp, BsGraphDown } from 'react-icons/bs'

const LoggedTemplate = ( { children, title = "Financeiro", subTitle }:Props ) => {

  const navigate = useNavigate()
  const isLogged = useIsUserLogged()
  
  useEffect( () => {
    !isLogged && PAGES.login.path && navigate( PAGES.login.path )
  }, [ navigate, isLogged ] )

  const bottomMenu = useMemo( () => {
    return [ 
      {
        icon: <FaHome className="text-primary-dark"/>,
        route: PAGES.home.path
      },
      {
        icon: <BsGraphDown className="text-primary-dark"/>,
        route: PAGES.spends.path
      },
      {
        icon: <BsGraphUp className="text-primary-dark"/>,
        route: PAGES.received.path
      },
      {
        icon: <FaWallet className="text-primary-dark"/>,
        route: PAGES.accounts.path
      },
    ]
  }, [ ] )

  return !isLogged ? null : ( 
    <div className="w-screen h-full flex flex-col">
      <div className="w-full flex flex-col items-center justify-center shadow-md bg-purple-700">
        <span className="font-bold text-white text-xl h-12 flex items-center w-full justify-center">
          { title }
        </span>
        { subTitle &&
          <span className="font-bold text-white bg-purple-500 w-full flex items-center justify-center" onClick={ subTitle.action } >
            { subTitle.text }
          </span>
        }
      </div>
      <div className="flex-1 bg-gray-900 text-white flex items-center justify-center pb-24  ">
        {  children}
      </div>
      <div className="w-full h-24 relative">
        <div className="z-10 hidden absolute translate-x-2/4	right-1/2 -top-8 h-16 w-16 rounded-full bg-purple-500 shadow-md">
        </div>
        <div className="px-8 h-full flex items-center justify-between bg-purple-700">
          {
            bottomMenu.map( ( menu_item ) =>(
              <div 
                key={ uniqueId() } 
                className="bg-white shadow-md w-12 h-12 flex items-center justify-center rounded-md" 
                onClick={ () => navigate( menu_item.route ) }
              >
                { menu_item.icon }
              </div>
            ))
          }
        </div>
      </div>
    </div>
  )
}
interface Props extends PropsWithChildren<any> {
  title?: string,
  subTitle?: {
    text?: string,
    action?: () => void 
  }
}
export default LoggedTemplate