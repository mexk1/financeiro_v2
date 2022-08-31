import { PropsWithChildren, useEffect, useMemo, useState } from "react"
import { useLocation, useNavigate } from "react-router-dom"
import PAGES from "../../constants/PAGES"
import useIsUserLogged from "./hooks/useIsUserLogged"
import { FaHome, FaWallet } from 'react-icons/fa'
import { uniqueId } from "lodash"
import { BsGraphUp, BsGraphDown, BsBank2 } from 'react-icons/bs'
import { RiBankCardFill } from 'react-icons/ri'

import XHamburgerMenu from "../../components/XHamburgerMenu"
import useAccountContext from "../../context/AccountContext/useAccountContext"

const LoggedTemplate = ({ children }: Props) => {

  const navigate = useNavigate()
  const isLogged = useIsUserLogged()
  const location = useLocation()

  const [menuOpen, setMenuOpen] = useState(false)
  const { account } = useAccountContext()

  const title = useMemo( () => {
    type keyofPages = keyof typeof PAGES 
    const page = Object.keys( PAGES ).find( key => {
      return PAGES[key as keyofPages].path === location.pathname
    })

    return page && PAGES[page as keyofPages].name
  }, [ location ] ) 

  const toggleMenu = () => setMenuOpen(isOpen => !isOpen)

  useEffect(() => {
    !isLogged && PAGES.login.path && navigate(PAGES.login.path)
  }, [navigate, isLogged])

  const bottomMenu = useMemo(() => {
    return [
      [
        {
          icon: <FaWallet className="text-primary-dark" />,
          route: PAGES.accountsSelect.path
        },
        {
          icon: <BsGraphDown className="text-primary-dark" />,
          route: PAGES.spends.path
        }
      ],
      [
        {
          icon: <BsGraphUp className="text-primary-dark" />,
          route: PAGES.received.path
        },
        {
          icon: <BsBank2 className="text-primary-dark" />,
          route: PAGES.bankAccounts.path
        },
      ]
    ]
  }, [])

  const hiddenMenuItems = [
    {
      icon: <FaHome className="text-primary-dark" />,
      route: PAGES.home.path
    },
    {
      icon: <RiBankCardFill className="text-primary-dark" />,
      route: PAGES.cards.path
    },
  ]

  return !isLogged ? null : (
    <div className="w-screen h-full flex flex-col">
      <div className="w-full flex flex-col items-center justify-center shadow-md bg-purple-700">
        {
          account && 
            <span className="font-bold text-white text-xl h-12 flex items-center w-full justify-center">
              { account.name }
            </span>
        }
        {
          title && (
            <span className="font-bold bg-purple-600 text-white  h-6 flex items-center w-full justify-center">
              { title }
            </span>
          )
        }
      </div>
      <div className="flex-1 bg-gray-900 text-white flex items-center justify-center overflow-scroll">
        {children}
      </div>
      <div
        className={"transition-all bg-purple-700 w-full absolute px-8 h-screen bottom-0 left-0 " + (menuOpen ? ' max-h-60  pt-4 pb-16 ' : 'max-h-0')}
      >
        <div className="w-full h-full overflow-auto grid grid-cols-5 gap-8">
          {
            hiddenMenuItems.map( menu_item => (
              <div
                key={uniqueId()}
                className={"bg-white shadow-md w-10 h-10 flex items-center justify-center rounded-md shadow-purple-900 " + 
                ( menu_item.route === location.pathname ? 'border-2 border-green-500 ' : ' ' )
                } 
                onClick={() => navigate(menu_item.route)}
                >
                  {menu_item.icon}
              </div>
            ))
          }
        </div>
      </div>
      <div className="w-full relative">
        <div
          onClick={toggleMenu}
          className="z-20 absolute translate-x-2/4 right-1/2 -top-6 h-12 w-12 rounded-full bg-purple-500 shadow-sm shadow-purple-900 flex items-center justify-center"
        >
          <div className="w-6 h-6 flex items-center"> 
            <XHamburgerMenu open={menuOpen} />
          </div>
        </div>

        <div 
          className="z-10 px-8 py-2 h-full flex items-center justify-between bg-purple-700"
          style={ !menuOpen ? {} : {
            boxShadow: '0px 0px 15px -8px white'
          }}
        > 
          {
            bottomMenu.map(side => (
              <div className="flex items-center gap-8">
                {
                  side.map(menu_item => (
                    <div
                      key={uniqueId()}
                      className={"bg-white shadow-md w-10 h-10 flex items-center justify-center rounded-md shadow-purple-900 " + 
                        ( menu_item.route === location.pathname ? 'border-2 border-green-500 ' : ' ' )
                      }
                      onClick={() => navigate(menu_item.route)}
                    >
                      {menu_item.icon}
                    </div>
                  ))
                }
              </div>
            ))
          }
        </div>
      </div>
    </div>
  )
}
interface Props extends PropsWithChildren<any> {
}
export default LoggedTemplate