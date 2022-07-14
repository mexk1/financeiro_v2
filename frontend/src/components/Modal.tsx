import { PropsWithChildren, useCallback, useEffect, useMemo, useRef, useState } from "react"
import ReactDOM from "react-dom"

const Modal = ( { children, onClose, dismissable, isOpen }:ModalProps ) => { 

  const contentRef = useRef<HTMLDivElement>( null )

  const body = useMemo( () => {
    return document.querySelector('body')
  }, [] )

  const Component = useMemo( () => {

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
    return (
      <div className={ wrapperClasses.join(' ') + ( isOpen ? ' max-h-screen max-w-screen' : 'max-w-0 max-h-0' ) }>
        <div ref={ contentRef } className={ contentClasses.join(' ') } style={{minWidth: 200, minHeight: 200 }}>
          Hello 
        </div>
      </div>
    )
  }, [ contentRef, isOpen ] )

  const handleOutsideClick = useCallback( ( e:MouseEvent ) => {

    if( contentRef.current && e.composedPath().includes( contentRef.current ) ) return 

    onClose && onClose()
  }, [ contentRef ] ) 


  useEffect( () => {
    window.addEventListener( 'click', handleOutsideClick )
    return () => {
      window.removeEventListener( 'click', handleOutsideClick )
    }
  }, [] )

  return body && ReactDOM.createPortal( Component, body )
}

export interface ModalProps extends PropsWithChildren<{}> {
  onClose?: ( ) => void,
  dismissable?: boolean,
  isOpen?: boolean
}
export default Modal