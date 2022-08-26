
interface Props {
  open?: boolean
}
const XHamburgerMenu = ( { open }:Props ) => {

  const commonClasses = [
    "block w-full h-1 rounded absolute ",
    "transition-all ease-in-out bg-gray-800"
  ]

  return (
    <div className="w-full h-full flex items-center justify-center relative">
      <span 
        className={ commonClasses.join(" ") +  ( open ? " top-1/2 w-0 " : " top-0  " ) } 
      />

      <span 
        className={ commonClasses.join(" ") 
          + ( open ? " rotate-45 " : ' ' ) 
        } 
      />

      <span 
        className={ commonClasses.join(" ") 
          + ( open ? ' -rotate-45 ' : '  ' )
        } 
      />
      
      <span 
        className={ commonClasses.join(" ") + ( open ? " bottom-1/2 w-0 " : " bottom-0  " ) } 
      />
    </div>
  )
}


export default XHamburgerMenu