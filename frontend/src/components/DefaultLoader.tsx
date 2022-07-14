import { useMemo } from "react"

const DefaultLoader = ( { size }:Props ) => {


  const dimensions = useMemo( () => {
    
    if( size === 'small' ){
      return {
        width: '50px',
        height: '50px',
      }
    }

    if( size === 'large' ){
      return {
        width: '150px',
        height: '150px',
      }
    }

    return {
      width: '100px',
      height: '100px',
    }
  }, [ size ] )

  return (
    <svg xmlns="http://www.w3.org/2000/svg" xmlnsXlink="http://www.w3.org/1999/xlink" 
      style={{
        margin:"auto",
        display:"block",
      }} 
      width={ dimensions.width } 
      height={ dimensions.height } 
      viewBox="0 0 100 100" 
      preserveAspectRatio="xMidYMid"
    >
      <defs>
        <path id="path" d="M50 15A15 35 0 0 1 50 85A15 35 0 0 1 50 15" fill="none"></path>
        <path id="patha" d="M0 0A15 35 0 0 1 0 70A15 35 0 0 1 0 0" fill="none"></path>
      </defs><g transform="rotate(0 50 50)">
        <use xlinkHref="#path" stroke="#f1f2f3" strokeWidth="3"></use>
      </g><g transform="rotate(60 50 50)">
        <use xlinkHref="#path" stroke="#f1f2f3" strokeWidth="3"></use>
      </g><g transform="rotate(120 50 50)">
        <use xlinkHref="#path" stroke="#f1f2f3" strokeWidth="3"></use>
      </g><g transform="rotate(0 50 50)">
        <circle cx="50" cy="15" r="9" fill="#a855f7">
          <animateMotion dur="1s" repeatCount="indefinite" begin="0s">
            <mpath xlinkHref="#patha"></mpath>
          </animateMotion>
        </circle>
      </g><g transform="rotate(60 50 50)">
        <circle cx="50" cy="15" r="9" fill="#581c87">
          <animateMotion dur="1s" repeatCount="indefinite" begin="-0.16666666666666666s">
            <mpath xlinkHref="#patha"></mpath>
          </animateMotion>
        </circle>
      </g><g transform="rotate(120 50 50)">
        <circle cx="50" cy="15" r="9" fill="#7e22ce">
          <animateMotion dur="1s" repeatCount="indefinite" begin="-0.3333333333333333s">
            <mpath xlinkHref="#patha"></mpath>
          </animateMotion>
        </circle>
      </g>
    </svg>
  )
}

interface Props {
  size?: "small" | "medium" | "large"
}

export default DefaultLoader