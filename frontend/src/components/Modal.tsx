import { PropsWithChildren, useCallback, useEffect, useMemo, useRef, useState } from "react"
import ReactDOM from "react-dom"

const Modal = ( { children, onClose, dismissable = true , isOpen }:ModalProps ) => { 
  
  const contentRef = useRef<HTMLDivElement>( null )

  const body = document.querySelector('body')
  const wrapperClasses = [
    "fixed ",
    "overflow-auto" ,
    "flex items-center ",
    "justify-center"  ,
    "bg-black bg-opacity-50" ,
    "top-0",
    "left-0" ,
    "w-screen",
    "h-screen",
    'z-10',
    'transition',
    'transition-all',
    'duration-300'
  ]

  const contentClasses = [
    'z-10',
    'bg-white',
    'flex',
    'rounded-md',
    'shadow ',
    'shadow-primary-light',
    'items-center',
    'justify-center'
  ]

  const Component = (
    <div className={ wrapperClasses.join(' ') + ( isOpen ? ' max-h-screen max-w-screen' : 'max-w-0 max-h-0' ) }>
      <div ref={ contentRef } className={ contentClasses.join(' ') } style={{minWidth: 200, minHeight: 200 }}>
        {children} 
      </div>
    </div>
  )

  const handleOutsideClick = ( e:MouseEvent ) => {
    if( !dismissable ) return  
    if( contentRef.current && e.composedPath().includes( contentRef.current ) ) return 
    onClose && onClose()
  }
  
  useEffect( () => {
    setTimeout( () => { 
      window.addEventListener( 'click', handleOutsideClick )
    }, 200 )
    return () => {
      window.removeEventListener( 'click', handleOutsideClick )
    }
  }, [  ] )

  return body && ReactDOM.createPortal( Component, body )
}

export interface ModalProps extends PropsWithChildren<{}> {
  onClose?: ( ) => void,
  dismissable?: boolean,
  isOpen?: boolean
}
export default Modal